<?php

namespace App\Models;

use App\Traits\ActivityLogTrait;
use App\Traits\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MainModel extends Model
{
    use HasFactory, SoftDeletes, ActivityLogTrait,HasTrash;

    protected $casts = [
        'name' => \App\Casts\UnescapedJson::class,
        'description' => \App\Casts\UnescapedJson::class,
    ];


    public function nameLang($lang = null)
    {
        $data = $this->name;
        if ($lang === null) {
            $user = Auth::guard('api')->user();
            $langUser = $user ? $user->lang : app()->getLocale();
            $defaultLang = app()->getLocale();
            return $data[$langUser] ?? $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function descriptionLang($lang = null)
    {
        $data = $this->description;
        if ($lang === null) {
            $user = Auth::guard('api')->user();
            $langUser = $user ? $user->lang : app()->getLocale();
            $defaultLang = app()->getLocale();
            return $data[$langUser] ?? $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function scopeMainSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        $searchable = property_exists($this, 'searchable') ? $this->searchable : ['name', 'description'];

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


   
}
