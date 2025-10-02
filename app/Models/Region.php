<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends MainModel
{

    protected $fillable = [
        'name',
        'city_id',
        'active',
        'order_id',
        'shipping',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeFilter($query, $request=null,$type_app='app')
    {

        $request=$request??request();

        $query->orderBy('order_id','asc');

        $filters = $request->only(['active','city_id']);

        $query->mainApplyDynamicFilters($filters);

        $query->mainSearch($request->input('search'));
       return $query;
    }




}
