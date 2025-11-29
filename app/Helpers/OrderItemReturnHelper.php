<?php

namespace App\Helpers;

class OrderItemReturnHelper
{
    public static function getRelationsInSinglePage(): array
    {
        return ['user', 'order','orderItem.product','reason','coupon','approvedBy','rejectedBy'];
    }
    public static function getRelationsInIndex(): array
    {
        return ['user', 'order','orderItem.product','reason','coupon','approvedBy','rejectedBy'];
    }
}