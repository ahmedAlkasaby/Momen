<?php

namespace App\Models;


class Color extends MainModel   
{
    protected $fillable = [
        'name',
        'active',
        'order_id'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
