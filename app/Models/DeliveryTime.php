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

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
