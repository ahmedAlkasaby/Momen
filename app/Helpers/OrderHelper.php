<?php

namespace App\Helpers;  

use App\Enums\StatusOrderEnum;

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
            'orderStatuses'
        ];
    }

    public static function getSpanClassByStatus(string|StatusOrderEnum $status): string
    {
        $statusValue = $status instanceof StatusOrderEnum ? $status->value : $status;

        $result = match ($statusValue) {
            StatusOrderEnum::Request->value           => 'bg-label-secondary',
            StatusOrderEnum::Pending->value           => 'bg-label-warning',
            StatusOrderEnum::Approved->value          => 'bg-label-info',
            StatusOrderEnum::Preparing->value         => 'bg-label-primary',
            StatusOrderEnum::PreparingFinished->value => 'bg-label-primary',
            StatusOrderEnum::DeliveryGo->value        => 'bg-label-primary',
            StatusOrderEnum::Delivered->value         => 'bg-label-success',
            StatusOrderEnum::Canceled->value          => 'bg-label-danger',
            StatusOrderEnum::ReturnedPartial->value   => 'bg-label-alert',
            StatusOrderEnum::Returned->value          => 'bg-label-alert',
            StatusOrderEnum::Rejected->value          => 'bg-label-alert',
            default                                   => 'bg-label-default',
        };
        return $result;
    }
}