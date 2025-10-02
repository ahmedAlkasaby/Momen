<?php

namespace Database\Seeders;

use App\Helpers\HourHelper;
use App\Models\DeliveryTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $faker = Faker::create();

        $timeSlots = array_values(HourHelper::fullDayRange());

        for ($i = 0; $i < 10; $i++) {
            $start = $faker->randomElement($timeSlots);
            $end = $faker->randomElement($timeSlots);

            if (strtotime($end) <= strtotime($start)) {
                $end = $start;
            }

            DeliveryTime::create([
                'name' => [
                    'en' => $faker->word(),
                    'ar' => $faker->word(),
                ],
                'start_hour' => $start,
                'end_hour'   => $end,
                'active'     => rand(0, 1),
            ]);
        }
    }
}
