<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name'=>"ahmed",
            'email'=>'ahmed@gmail.com',
            'password'=>Hash::make('ahmed145'),
            'is_admin'=>1
        ]);

        for($i=0;$i<10;$i++){
            User::create([
                'name'=>"ahmed",
                'email'=>'ahmed'.$i.'@gmail.com',
                'password'=>Hash::make('ahmed145'),
            ]);
        }
    }
}
