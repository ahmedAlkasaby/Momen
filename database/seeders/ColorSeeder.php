<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => ['en' => 'Red',    'ar' => 'أحمر'],   'active' => 1, 'order_id' => 1],
            ['name' => ['en' => 'Blue',   'ar' => 'أزرق'],   'active' => 1, 'order_id' => 2],
            ['name' => ['en' => 'Green',  'ar' => 'أخضر'],   'active' => 1, 'order_id' => 3],
            ['name' => ['en' => 'Black',  'ar' => 'أسود'],   'active' => 1, 'order_id' => 4],
            ['name' => ['en' => 'White',  'ar' => 'أبيض'],   'active' => 1, 'order_id' => 5],
            ['name' => ['en' => 'Yellow', 'ar' => 'أصفر'],   'active' => 1, 'order_id' => 6],
            ['name' => ['en' => 'Orange', 'ar' => 'برتقالي'],'active' => 1, 'order_id' => 7],
            ['name' => ['en' => 'Purple', 'ar' => 'بنفسجي'],'active' => 1, 'order_id' => 8],
            ['name' => ['en' => 'Gray',   'ar' => 'رمادي'],  'active' => 1, 'order_id' => 9],
            ['name' => ['en' => 'Brown',  'ar' => 'بني'],    'active' => 1, 'order_id' => 10],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['name' => $color['name']], // الشرط
                $color                      // القيم
            );
        }
    }
}
