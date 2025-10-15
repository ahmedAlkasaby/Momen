<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Color;
use App\Models\Reason;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        



        
        $this->call([
            // basics
            LaratrustSeeder::class,
            AdminSeeder::class,
            SettingSeeder::class,


            ReasonSeeder::class,
            OrderRejectSeeder::class,
            UserSeeder::class,
            PaymentSeeder::class,
            DeliveryTimeSeeder::class,
            CitySeeder::class,
            RegionSeeder::class,
            StoreSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
            PageSeeder::class,
            AddressSeeder::class,
            NotificationSeeder::class,
            CouponSeeder::class,    
            // ContactSeeder::class,
            // AddressSeeder::class,
            // OrderSeeder::class
        ]);
       






    }
}
