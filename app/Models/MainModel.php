<?php

namespace App\Models;

use App\Traits\ActivityLogTrait;
use App\Traits\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'name' => \App\Casts\UnescapedJson::class,
        'title' => \App\Casts\UnescapedJson::class,
        'content' => \App\Casts\UnescapedJson::class,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (array_key_exists('link', $model->getAttributes()) || in_array('link', $model->getFillable())) {

                if (empty($model->link)) {

                    $name = $model->nameLang('en');


                    $slug = $name ? Str::slug($name) : Str::slug(Str::random(8));
                    $original = $slug;
                    $count = 1;

                    while (DB::table($model->getTable())->where('link', $slug)->exists()) {
                        $slug = $original . '-' . $count++;
                    }

                    $model->link = $slug;
                }
            }
        });
    }

    public static function listForSelect(
        $type = null,
        $key = 'id',
        $valueMethod = 'nameLang',
        $queryScope = 'active',
        $columns = ['id', 'name'],
    ) {
        $query = static::query();

        if (method_exists(static::class, 'scope' . ucfirst($queryScope))) {
            $query = (new static)->$queryScope($query);
        }

        $query->select($columns);

        $items = $query->get()->mapWithKeys(function ($item) use ($key, $valueMethod) {
            return [$item->$key => $item->$valueMethod()];
        })->toArray();

        if ($type === 'default') {
            $items = defaultOption() + $items;
        } elseif ($type === 'filter') {
            $items = filterOption() + $items;
        }

        return $items;
    }





    public function nameLang($lang = null)
    {
        $data = $this->name;
        if ($lang === null) {

            $defaultLang = app()->getLocale();
            return $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function contentLang($lang = null)
    {
        $data = $this->content;
        if ($lang === null) {

            $defaultLang = app()->getLocale();
            return  $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function titleLang($lang = null)
    {
        $data = $this->title;
        if ($lang === null) {

            $defaultLang = app()->getLocale();
            return  $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }



    public function scopeMainSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        $searchable = property_exists($this, 'searchable') ? $this->searchable : ['name', 'content'];

        $query->where(function ($q) use ($search, $searchable) {
            foreach ($searchable as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $relColumn] = explode('.', $column, 2);
                    $q->orWhereHas($relation, function ($q2) use ($relColumn, $search) {
                        $q2->where($relColumn, 'like', "%{$search}%");
                    });
                } else {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            }
        });

        return $query;
    }

    public function scopeMainApplyDynamicFilters($query, $filters = [])
    {
        foreach ($filters as $column => $value) {
            if (!is_null($value) && $value !== 'all') {
                $query->where($column, $value);
            }
        }

        return $query;
    }

    public function scopeNewest($query)
    {
        return $query->orderByDesc('id');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('id');
    }

    public function scopeOrderNo($query)
    {
        return $query->orderByRaw('order_id IS NULL')
            ->orderBy('order_id', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderNo();
    }

    public function scopeTrash($query, $request = null)
    {
        if ($request->filled('trash')) {
            if ($request->input('trash') == 'all') {
                $query->withTrashed();
            } else if ($request->input('trash') == '0') {
                $query->onlyTrashed();
            } else {
                $query->withoutTrashed();
            }
        }
        return $query;
    }
}
