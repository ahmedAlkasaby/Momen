<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {

        for ($i = 1; $i <= 5; $i++) {
            Coupon::create([
                'name' => [
                    'en' => 'Coupon ' . $i,
                    'ar' => 'كوبون ' . $i,
                ],
                'content' => [
                    'en' => 'Content for coupon ' . $i,
                    'ar' => 'وصف للكوبون ' . $i,
                ],
                'code' => 'CODE' . strtoupper(uniqid($i)),
                'type' => $i % 2 == 0 ? 'fixed' : 'percent',
                'discount' => $i % 2 == 0 ? 50 : 10,
                'max_discount' => 100,
                'min_order' => 50,
                'user_limit' => 1,
                'use_limit' => 100,
                'use_count' => 0,
                'date_start' => Carbon::now(),
                'date_expire' => Carbon::now()->addMonths(2),
                'day_start' => Carbon::now()->toDateString(),
                'day_expire' => Carbon::now()->addMonths(2)->toDateString(),
                'order_id' => $i,
                'finish' => 0,
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
