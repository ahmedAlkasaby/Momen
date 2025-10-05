<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Service;
use App\Models\Size;
use App\Models\Store;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {

            $dataProduct=$this->getDataProduct();
            $dataOffer=$this->getOfferData($dataProduct['is_offer'],$dataProduct['price']);
            $dataShipping=$this->getShippingData($dataProduct['is_shipping_free']);
            $data = array_merge($dataProduct, $dataOffer, $dataShipping);
            $categoryIds = $this->getCategoryData(3);

            $product=Product::create($data);
            $product->categories()->sync($categoryIds);

            $dataProductParent=Arr::except($data,[
                'price',
                'offer_price',
                'is_offer',
                'size_id',
                'color_id',
                'parent_id',
            ]);

            if (rand(0,1)==1){

                foreach ($this->getChlidrenData($dataProduct['is_offer'],$product->id,
                    Size::inRandomOrder()->first()->id,
                    Color::inRandomOrder()->first()->id,rand(3,5)) as $childData) {
                    $clidermProduct=Product::create(array_merge($dataProductParent,$childData));
                }
            }
        }



    }


    public function getDataProduct(): array
    {
        return [
            'name'=>[
                'en'=>fake()->word(),
                'ar'=>fake()->word(),
            ],
            'content'=>[
                'en'=>fake()->text(),
                'ar'=>fake()->text(),
            ],
            'code' => fake()->unique()->bothify('PROD-####'),
            'image'=>'products\productDefoult.png',
            'price'=>rand(100,1000),

            'order_limit'=>rand(1,2),
            'max_order'=>rand(1,10),

            'active'=>rand(0,1),
            'is_stock'=>rand(0,1),
            'is_filter'=>rand(0,1),
            'is_offer'=>rand(0,1),
            'is_new'=>rand(0,1),
            'is_special'=>rand(0,1),
            'is_returned'=>rand(0,1),
            'is_shipping_free'=>rand(0,1),
          
            'unit_id'=> Unit::where('active',1)->inRandomOrder()->first()->id,
        ];
    }


    public function getOfferData($isOffer,$price): array
    {
        if($isOffer==1){
            return [
                'offer_price'=>$price + rand(1,100),
            ];
        }else{
            return [
                'offer_price'=>null,
            ];
        }
    }

    public function getShippingData($isShipping): array
    {
        if($isShipping==1){
            return [
                'shipping'=>rand(1,100),
            ];
        }else{
            return [
                'shipping'=>0,
            ];
        }
    }

    public function getChlidrenData($offer,$parentId,$sizeId,$colorId,$count){
        $data=[];

        for ($i=0; $i < $count; $i++) {
            $price=rand(100,1000);
            $data[]=array_merge($this->getOfferData($offer,$price),[
            'price'=>$price,
            'is_offer'=>$offer,
            'parent_id'=>$parentId,
            'size_id'=>$sizeId,
            'color_id'=>$colorId
            ]);

        }

        return $data;
    }

    public function getCategoryData($count): array
    {
        return Category::activeCategories()
                       ->inRandomOrder()
                       ->limit($count)
                       ->pluck('id')
                       ->toArray();
    }






}
