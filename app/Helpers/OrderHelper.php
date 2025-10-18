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
            'coupon',
            'region',
            'city',
            'orderReject',
        ];
    }
    public static function getOrderRelationsInSinglePage() :array
    {
        return [
            'user',
            'address',
            'delivery',
            'payment',
            'deliveryTime',
            'orderItems.product',
            'orderItems.productChild',
            'orderItems.OrderItemReturn',
            'orderItems.OrderItemReturn.reason',
            'orderItemReturns.reason',
            'coupon',
            'region',
            'city',
            'orderReject',  
        ];
    }
}