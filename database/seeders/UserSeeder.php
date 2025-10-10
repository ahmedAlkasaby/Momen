<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name_first'=>'ahmed',
            'name_last'=>'alkasaby',
            'email'=> 'ahmedalkasaby21@gmail.com',
            'phone'=> '01016192605',
            'password'=> 'ahmed145',
            'locale'=>'en',
            'theme'=>'light',
            'type'=>'admin',
        ]);
        $user->devices()->create([
            'token'=>fake()->uuid(),
            'device_type'=>'android',
            'imei'=>fake()->uuid(),

        ]);
          for ($i = 0; $i < 10; $i++) {
            $user = User::create([
              'name_first'=>fake()->firstName(),
              'name_last'=>fake()->lastName(),
              'email'=> fake()->unique()->safeEmail(),
              'phone'=> fake()->phoneNumber(),
              'password'=> fake()->password(),
              'locale'=>'en',
              'theme'=>'light',
              'type'=>fake()->randomElement(['admin', 'client','delivery']),
              'active'=>1,
              'is_notify'=>1
           ]);

           $user->devices()->create([
               'token'=>fake()->uuid(),
               'device_type'=>fake()->randomElement(['android', 'apple', 'huawei']),
               'imei'=>fake()->uuid(),
    
           ]);
        }
    }
}
