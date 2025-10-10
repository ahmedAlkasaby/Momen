<?php

namespace App\Helpers;  

class OrderHelper
{
    public static function getOrderRelations() :array
    {
        return [
            'user',
            'address',
            'delivery',
            'payment',
            'deliveryTime',
            'orderItems.product',
            'orderItems.productChild',
            'coupon',
            'region',
            'city',
        ];
    }
}