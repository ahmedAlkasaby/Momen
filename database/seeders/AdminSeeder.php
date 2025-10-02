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
           'first_name'=>'Ahmed',
           'last_name'=>'Alkasaby',
           'email'=>'alkasaby145@gmail.com',
           'password'=>'ahmed145',
           'phone'=>'01000000000',
           'lang'=>'en',
           'theme'=>'light',
           'type'=>'admin'
       ]);
       $user->addRole('super_admin');
    }
}
