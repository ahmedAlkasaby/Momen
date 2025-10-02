<?php

namespace App\Helpers;

class StockAlertHelper{

    public static function lowStockMessage($productNameAr,$productNameEn, $currentQuantity, $minThreshold, $zipCode)
    {
        return [
            'title_ar' => '🚨 تنبيه بنفاد المخزون',
            'title_en' => '🚨 Low Stock Alert',
    
            'body_ar' => "⚠️ المنتج: \"{$productNameAr}\"\n📦 الكمية الحالية: {$currentQuantity}\n📉 الحد الأدنى المسموح به: {$minThreshold}\n📮 الرمز : {$zipCode}\n\n🔔 يرجى اتخاذ الإجراءات اللازمة في أقرب وقت ممكن.",
    
            'body_en' => "⚠️ Product: \"{$productNameEn}\"\n📦 Current quantity: {$currentQuantity}\n📉 Minimum threshold: {$minThreshold}\n📮  Code: {$zipCode}\n\n🔔 Please take the necessary action as soon as possible.",
        ];
    }

}