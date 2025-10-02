<?php

namespace App\Helpers;

class OrderNotificationData
{
    public static function getData($type)
    {
        switch ($type) {
            case 'request':
                return [
                    'title_ar' => 'طلب جديد',
                    'title_en' => 'new order',
                    'body_ar' => 'سيتم الرد على الطلب في اقرب وقت',
                    'body_en' => 'respond to your order as soon as possible',
                ];
                break;
            case 'canceled':
                return [
                    'title_ar' => 'تم الغاء الطلب',
                    'title_en' => 'The order has been canceled',
                    'body_ar' => 'تم الغاء الطلب من قبل المستخدم',
                    'body_en' => 'order has been canceled by the user',
                ];
                break;

            default:
                return [
                    
                ];
                break;
        }
    }
}
