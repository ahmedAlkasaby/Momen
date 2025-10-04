<?php

namespace App\Models;


class Category extends MainModel
{
    protected $fillable = [
        'name',
        'link',
        'content',
        'image',
        'parent_id',
        'active',
        'order_id'
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function activeChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('active', 1)->orderNo();
    }
   
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeActiveParents($query){
        return $query->where('active', 1)
                     ->whereNull('parent_id')
                     ->whereHas('children')
                     ->orderBy('order_id', 'asc');
    }


    public function scopeActiveCategories($query)
    {
        return $query->where('active', 1)
                     ->whereDoesntHave('children')
                     ->orderBy('order_id', 'asc');
    }



    public function scopeFilter($query, $request = null, $type_app = 'app')
    {

        $request = $request ?? request();
        $filters = $request->only(['parent_id']);
        $type_app == 'app' ?  $query->where('active',1) :  $query->where('active',$request->input('active'));
        $query->orderNo();
        
        $query->mainSearch($request->input('search'));


        $query->mainApplyDynamicFilters($filters);

        if ($request->has('is_parents')==1) {
            $query->whereNull('parent_id');
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'latest':
                    $query->orderByDesc('id');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        }

        return $query;
    }
}