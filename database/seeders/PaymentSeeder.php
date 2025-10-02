<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) {

            Payment::create([
                   'name'=>[
                        'en'=>fake()->word(),
                        'ar'=>fake()->word(),
                    ],
                    'description'=>[
                        'en'=>fake()->text(),
                        'ar'=>fake()->text(),
                    ],
                    'image'=>'uploads\payments\download.jpeg',
                    'active'=>rand(0,1),
                    'order_id'=>rand(1,10),
            ]);
        }




    }
}





