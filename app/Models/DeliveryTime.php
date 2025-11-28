<?php

namespace App\Models;



class DeliveryTime extends MainModel
{
    protected $fillable = [
        'name',
        'order_id',
        'start_hour',
        'end_hour',
        'active',
    ];

   
}
