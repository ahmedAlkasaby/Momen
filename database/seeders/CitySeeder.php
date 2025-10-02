<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            City::create([
                'name'=>[
                    'en'=>fake()->word(),
                    'ar'=>fake()->word(),
                ],
                'active'=>1,
                'shipping'=>rand(0,50),
            ]);
        }
    }
}
