<?php

namespace App\Helpers;

class ModelHelper{
    public static function models(){
    return   [
            'settings' => 'App\Models\Setting',
            'users' => 'App\Models\User',
            'roles' => 'App\Models\Role',
            'services' => 'App\Models\Service',
            'categories' => 'App\Models\Category',
            'products' => 'App\Models\Product',
            'units' => 'App\Models\Unit',
            'sizes' => 'App\Models\Size',
            'brands' => 'App\Models\Brand',
            'pages' => 'App\Models\Page',
            'sliders' => 'App\Models\Slider',
            'orders' => 'App\Models\Order',
            'cities' => 'App\Models\City',
            'regions' => 'App\Models\Region',
            'notifications' => 'App\Models\Notification',
            'payments' => 'App\Models\Payment',
            'delivery_times' => 'App\Models\DeliveryTime',
        ];

    }
}
