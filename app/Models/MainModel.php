<?php

namespace App\Models;

use App\Scopes\MainScope;
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
    use HasFactory, SoftDeletes,MainScope;

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



   
}
