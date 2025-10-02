<?php

namespace Database\Seeders;

use App\Models\Addition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Size;
use App\Models\Store;
use App\Models\StoreType;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    // use WithoutModelEvents;

    public function run(): void
    {


        

        // Create units
        for ($i = 1; $i < 6; $i++) {
            Unit::create([
                'name' => [
                    'en' => 'unit Type ' . $i,
                    'ar' => 'نوع الوحدة ' . $i,
                ],
                'content' => [
                    'en' => 'Content for unit Type ' . $i,
                    'ar' => 'وصف لنوع الوحدة ' . $i,
                ],
                'active' => true,
                'order_id' => $i,
            ]);
        }

        // Create brands
        for ($i = 1; $i < 6; $i++) {
            Brand::create([
                'name' => [
                    'en' => 'Brand ' . $i,
                    'ar' => 'العلامة التجارية ' . $i,
                ],
                'content' => [
                    'en' => 'Content for Brand ' . $i,
                    'ar' => 'وصف للعلامة التجارية ' . $i,
                ],
                'image' => 'uploads/storeTypes/storeTypeDefoult.jpg',
                'active' => true,
                'order_id' => $i,
            ]);
        }

        // Create sizes
        for ($i = 1; $i < 6; $i++) {
            Size::create([
                'name' => [
                    'en' => 'Size ' . $i,
                    'ar' => 'المقاس ' . $i,
                ],
                'content' => [
                    'en' => 'Content  for Size ' . $i,
                    'ar' => 'وصف للمقاس ' . $i,
                ],
                'active' => true,
                'order_id' => $i,
            ]);
        }

        // Create categories and subcategories
        for ($i = 1; $i < 6; $i++) {
            $category = Category::create([
                'name' => [
                    'en' => 'Category ' . $i,
                    'ar' => 'الفئة ' . $i,
                ],
                'content' => [
                    'en' => 'Content for Category ' . $i,
                    'ar' => 'وصف للفئة ' . $i,
                ],
                'image' => 'categories/categoryDefoult.jpg',
                'active' => true,
                'order_id' => $i,
                'parent_id' => null,
            ]);

            for ($j = 1; $j < 6; $j++) {
                $category->children()->create([
                    'name' => [
                        'en' => 'Subcategory ' . $j,
                        'ar' => 'فئة فرعية ' . $j,
                    ],
                    'content' => [
                        'en' => 'Content  for Subcategory ' . $j,
                        'ar' => 'وصف للفئة الفرعية ' . $j,
                    ],
                    'image' => 'categories/categoryDefoult.jpg',
                    'active' => true,
                    'order_id' => $j,
                ]);
            }
        }

        
    }
}
