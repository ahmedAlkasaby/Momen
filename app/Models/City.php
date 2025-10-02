<?php

namespace App\Models;


class City extends MainModel
{

    protected $fillable = [
        'name',
        "order_id",
        "shipping",
        "active",
    ];

     public function scopeFilter($query, $request=null,$type_app='app')
    {

        $request=$request??request();
        $filters = $request->only(['active']);

        $query->orderBy('order_id','asc');

        $query->mainApplyDynamicFilters($filters);

        $query->mainSearch($request->input('search'));

       return $query;
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }



}
