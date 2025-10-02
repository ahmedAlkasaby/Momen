<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 0; $i < 10; $i++) {
            Contact::create([
                "email" => "osamy8088@gmail.com",
                "message" => fake()->text(),
                "read_at" => fake()->dateTime(),
                "title" => fake()->title(),
                "read_at" => fake()->dateTime(),
            ]);
        }
    }
}
