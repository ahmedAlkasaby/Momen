<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Color;
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
            SettingSeeder::class,
            PaymentSeeder::class,
            DeliveryTimeSeeder::class,
            CitySeeder::class,
            RegionSeeder::class,
            StoreSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
            PageSeeder::class,
            // UserSeeder::class,
            // AddressSeeder::class,
            // NotificationSeeder::class,
            // ContactSeeder::class,
            // PaymentSeeder::class,
            // AddressSeeder::class,
            // OrderSeeder::class
        ]);
       






    }
}
