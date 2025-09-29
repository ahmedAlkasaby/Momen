<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facker=\Faker\Factory::create();
        for($i=0;$i<5;$i++){
            Category::create([
                // 'category_id'=>Category::inRandomOrder()->first()->id,
                'name'=>$facker->sentence(1),
                'image'=>'assets\img\1.jpg',
                'slug'=>Str::of('ahmed'.uniqid())->slug('-'),
                'description'=>$facker->paragraph(),
                'short_description'=>$facker->sentence(5),

                
                'trend'=>1,
                'showing'=>1
                // 'body'=>$facker->paragraph(),
            ]);
        }
    }
}
