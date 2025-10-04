<?php

namespace Database\Seeders;

use App\Helpers\PageHelper;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $types = PageHelper::getPagesTypes();

            Page::create([
                'name' => [
                    'en' => fake()->word(),
                    'ar' => fake()->word(),
                ],
                'title' => [
                    'en' => fake()->word(),
                    'ar' => fake()->word(),
                ],
                'content' => [
                    'en' => fake()->text(),
                    'ar' => fake()->text(),
                ],
                'active' => rand(0, 1),
                'feature' => rand(0, 1),
                'type' => 'page',
                'page_type' => $types[array_rand($types)], 
                'order_id' => rand(1, 10),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            Page::create([
                'name' => [
                    'en' => fake()->word(),
                    'ar' => fake()->word(),
                ],

                'content' => [
                    'en' => fake()->text(),
                    'ar' => fake()->text(),
                ],
                'image' => 'sliders\sliderDefoult.png',
                'active' => rand(0, 1),
                'feature' => rand(0, 1),
                'type' => 'slider',
                'product_id' => rand(0, 1) == 1 ? null : Product::where('active', 1)->inRandomOrder()->first()->id,
                'order_id' => rand(1, 10),
            ]);
        }
    }
}
