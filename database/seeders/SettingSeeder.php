<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🟢 الإعدادات العامة (Group: setting)
        // [ القيمة الافتراضية, نوع الحقل (type), قواعد التحقق (validation_rules), order_id ]
        $generalSettingsData = [
            // الهوية والاتصال
            'site_title'                  => ['Alkasaby',             'text',     'required|string|max:255', 10],
            'logo'                        => ['website\assets\Momen Logo.svg',    'file',     'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', 20],
            'site_email'                  => ['support@myshop.com',   'email',    'required|email|max:255', 30],
            'site_phone'                  => ['01016192604',          'text',     'nullable|string|max:15', 40],
            'site_open'                   => ['yes',                  'boolean',  'required|in:yes,no', 50],
            
            // إعدادات الأرقام والعمليات
            'delivery_cost'               => [20,                     'number',   'required|integer|min:0', 60],
            'min_order_for_shipping_free' => [300,                    'number',   'required|integer|min:0', 70],
            'min_order'                   => [50,                     'number',   'required|integer|min:0', 80],
            'max_order'                   => [2000,                   'number',   'required|integer|min:50', 90],
            'return_period_days'          => [14,                     'number',   'required|integer|min:1', 100],
            'result'                      => [100,                    'select',   'required|integer|min:0|max:250', 110], // ترك 'result' للأمان
        ];

        foreach ($generalSettingsData as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key], // البحث بناءً على المفتاح
                [
                    'group'              => 'setting',
                    'value'              => $data[0],
                    'type'               => $data[1], 
                    'validation_rules'   => $data[2], 
                    'order_id'           => $data[3], // 💡 تم إضافة order_id هنا
                ]
            );
        }

        // 🟣 إعدادات السوشيال (Group: social)
        // [ القيمة الافتراضية, نوع الحقل (type), قواعد التحقق (validation_rules), order_id ]
        $socialSettingsData = [
            // السوشيال ميديا
            'facebook'    => ['https://www.facebook.com/myshop', 'url', 'nullable|url|max:255', 10],
            'instagram'   => ['https://www.instagram.com/myshop', 'url', 'nullable|url|max:255', 20],
            'twitter'     => ['https://twitter.com/myshop', 'url', 'nullable|url|max:255', 30],
            'whatsapp'    => ['https://wa.me/966500000000', 'url', 'nullable|url|max:255', 40],
            'youtube'     => ['https://www.youtube.com/@myshop', 'url', 'nullable|url|max:255', 50],
            'tiktok'      => ['https://www.tiktok.com/@myshop', 'url', 'nullable|url|max:255', 60],
            'snapchat'    => ['https://www.snapchat.com/add/myshop', 'url', 'nullable|url|max:255', 70],
            'telegram'    => ['https://t.me/myshop', 'url', 'nullable|url|max:255', 80],
        ];

        foreach ($socialSettingsData as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group'              => 'social',
                    'value'              => $data[0],
                    'type'               => $data[1], 
                    'validation_rules'   => $data[2], 
                    'order_id'           => $data[3], // 💡 تم إضافة order_id هنا
                ]
            );
        }
    }
}