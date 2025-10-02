<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            Slider::create([
                'name'=>[
                    'en'=>fake()->word(),
                    'ar'=>fake()->word(),
                ],
                'description'=>[
                    'en'=>fake()->text(),
                    'ar'=>fake()->text(),
                ],
                'image'=>'uploads\sliders\685ee90b4219a.png',

                'active'=>rand(0,1),
                'feature'=>rand(0,1),
                'product_id'=>rand(0,1) == 1 ? null : Product::where('active',1)->inRandomOrder()->first()->id,
                'order_id'=>rand(1,10),
                "type"=>rand(0,1) == 1 ? 'product' : 'link',
            ]);
        }
    }
}
