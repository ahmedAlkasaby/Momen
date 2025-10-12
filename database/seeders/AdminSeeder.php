<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user=User::create([
           'name_first'=>'Ahmed',
           'name_last'=>'Alkasaby',
           'email'=>'alkasaby145@gmail.com',
           'password'=>'ahmed145',
           'phone'=>'01016192604',
           'locale'=>'ar',
           'theme'=>'light',
           'type'=>'admin',
           'active'=>1,
           'is_notify'=>1,
       ]);
       $user->addRole('super_admin');
    }
}
