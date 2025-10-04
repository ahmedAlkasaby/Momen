<?php

namespace App\Models;



class Payment extends MainModel
{

    protected $fillable = [
        'name',
        'content',
        'active',
        'image',
        'order_id'
    ];


    

    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }
}
