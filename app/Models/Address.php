<?php

namespace App\Models;

use App\Enums\TypeAddressEnum;


class Address extends MainModel
{

    protected $fillable = [
        'user_id',
        'type',
        'city_id',
        'region_id',
        'is_main',
        'latitude',
        'longitude',
        'address',
        'geo_address',
        'geo_state',
        'geo_city',
        'place_id',
        'postal_code',
        'building',
        'floor',
        'apartment',
        'phone',
        'additional_info'
    ];

    protected $casts=[
        'type'=>TypeAddressEnum::class,
    ];

    protected $searchable = [
        'address',
        'phone',
        'user.name',
        'city.name',
        'region.name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
