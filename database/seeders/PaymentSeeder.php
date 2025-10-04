<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    
    public function run(): void
    {
        
        Payment::create([
               'name'=>[
                    'en'=>'Cash',
                    'ar'=>'كاش',
                ],
               
                'image'=>'payments\Paymentcash.jpg',
                'active'=>rand(0,1),
                'order_id'=>rand(1,10),
        ]);
    }
}





