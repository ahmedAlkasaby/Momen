<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 50; $i++) {
            Notification::create([
                'name'=>[
                    'en'=>fake()->word(),
                    'ar'=>fake()->word(),
                ],
                'description'=>[
                    'en'=>fake()->text(),
                    'ar'=>fake()->text(),
                ],
                'user_id'=>User::inRandomOrder()->first()->id,
                'read_at'=>null,
            ]);
        }
    }
}
