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
        $query->orderNo();
        $type_app == 'app' ?  $query->where('active',1) :  $query->where('active',$request->input('active'));
        $query->mainSearch($request->input('search'));

       return $query;
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }



}
