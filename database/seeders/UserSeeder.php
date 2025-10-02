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
          for ($i = 0; $i < 10; $i++) {
            $user = User::create([
              'first_name'=>fake()->firstName(),
              'last_name'=>fake()->lastName(),
              'email'=> fake()->unique()->safeEmail(),
              'phone'=> fake()->phoneNumber(),
              'password'=> fake()->password(),
              'lang'=>'en',
              'theme'=>'light',
              'type'=>fake()->randomElement(['admin', 'client','delivery']),
           ]);

           $user->devices()->create([
               'token'=>fake()->uuid(),
               'device_type'=>fake()->randomElement(['android', 'apple', 'huawei']),
               'imei'=>fake()->uuid(),
    
           ]);
        }
    }
}
