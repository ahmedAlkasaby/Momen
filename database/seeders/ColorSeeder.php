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
            ['name' => ['en' => 'Red',    'ar' => 'أحمر'], 'code'=>'#ff0000' , 'active' => 1, 'order_id' => 1],
            ['name' => ['en' => 'Blue',   'ar' => 'أزرق'], 'code'=>'#0000ff',  'active' => 1, 'order_id' => 2],
            ['name' => ['en' => 'Green',  'ar' => 'أخضر'], 'code'=>'#00ff00' , 'active' => 1, 'order_id' => 3],
            ['name' => ['en' => 'Black',  'ar' => 'أسود'], 'code'=>'#000000' , 'active' => 1, 'order_id' => 4],
            ['name' => ['en' => 'White',  'ar' => 'أبيض'],  'code'=>'#ffffff', 'active' => 1, 'order_id' => 5],
            ['name' => ['en' => 'Yellow', 'ar' => 'أصفر'], 'code'=>'#ffff00',  'active' => 1, 'order_id' => 6],
            ['name' => ['en' => 'Orange', 'ar' => 'برتقالي'],'code'=>'#ffa500','active' => 1, 'order_id' => 7],
            ['name' => ['en' => 'Purple', 'ar' => 'بنفسجي'],'code'=>'#800080','active' => 1, 'order_id' => 8],
            ['name' => ['en' => 'Gray',   'ar' => 'رمادي'], 'code'=>'#808080' ,'active' => 1, 'order_id' => 9],
            ['name' => ['en' => 'Brown',  'ar' => 'بني'],  'code'=>'#a52a2a' , 'active' => 1, 'order_id' => 10],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['name' => $color['name']], // الشرط
                $color                      // القيم
            );
        }
    }
}
