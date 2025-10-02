<?php

namespace Database\Seeders;

use App\Helpers\PageHelper;
use App\Models\Page;
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
            Page::create([
                'name' => [
                    'en' => fake()->word(),
                    'ar' => fake()->word(),
                ],
                'description' => [
                    'en' => fake()->text(),
                    'ar' => fake()->text(),
                ],
                'image' => 'uploads\sliders\685ee90b4219a.png',
                'active' => rand(0, 1),
                'type' =>array_rand(PageHelper::getPagesTypes()),
                'order_id' => rand(1, 10),
            ]);
        }
    }
}
