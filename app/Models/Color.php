<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
