<?php

namespace App\Models;



class DeliveryTime extends MainModel
{
    protected $fillable = [
        'name',
        'start_hour',
        'end_hour',
        'active',
    ];

   
}
