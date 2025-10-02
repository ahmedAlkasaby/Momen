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
         Setting::create([
            'site_title' => 'Alkasaby',
            'site_phone' => '01016192604',
            'site_email' => 'support@myshop.com',
            'min_order' => 50,
            'max_order' => 2000,
            'min_order_for_shipping_free' => 300,
            'delivery_cost' => 20,
            'site_open' => true,
            'active' => true,
            'result' => 100,
            'logo' => 'uploads/settings/logo.png',

            'facebook' => 'https://www.facebook.com/myshop',
            'youtube' => 'https://www.youtube.com/@myshop',
            'whatsapp' => 'https://wa.me/966500000000',
            'snapchat' => 'https://www.snapchat.com/add/myshop',
            'instagram' => 'https://www.instagram.com/myshop',
            'twitter' => 'https://twitter.com/myshop',
            'tiktok' => 'https://www.tiktok.com/@myshop',
            'telegram' => 'https://t.me/myshop',
        ]);
    }
}
