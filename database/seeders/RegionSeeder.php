<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i=0; $i < 60; $i++) {
            Region::create([
                'name'=>[
                    'en'=>fake()->word(),
                    'ar'=>fake()->word(),
                ],
                'active'=>1,
                'shipping'=>rand(0,50),
                'city_id'=> City::where('active',1)->inRandomOrder()->first()->id,
            ]);
        }
    }
}
