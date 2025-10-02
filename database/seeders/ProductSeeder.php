<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
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
            $dataOffer=$this->getOfferData($dataProduct['offer'],$dataProduct['price']);
            $dataShipping=$this->getShippingData($dataProduct['free_shipping']);
            $data = array_merge($dataProduct, $dataOffer, $dataShipping);
            $categoryIds = $this->getCategoryData(3,$dataProduct['service_id']);

            $product=Product::create($data);
            $product->categories()->sync($categoryIds);

            $dataProductParent=Arr::except($data,[
                'amount',
                'price',
                'offer_price',
                'offer_percent',
                'offer_amount',
                'offer',
                'size_id',
                'parent_id',
            ]);

            if (rand(0,1)==1){

                foreach ($this->getChlidrenData($dataProduct['price'],$dataProduct['offer'],$product->id,Size::inRandomOrder()->first()->id,rand(3,5)) as $childData) {
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
            'description'=>[
                'en'=>fake()->text(),
                'ar'=>fake()->text(),
            ],
            'code' => fake()->unique()->bothify('PROD-####'),
            'image'=>'uploads\categories\685ee90b4219a.png',
            'price'=>rand(100,1000),
            'amount'=>rand(50,100),
            'max_order'=>rand(1,10),
            'active'=>rand(0,1),
            'offer'=>rand(0,1),
            'free_shipping'=>rand(0,1),
            'feature'=>rand(0,1),
            'new'=>rand(0,1),
            'special'=>rand(0,1),
            'filter'=>rand(0,1),
            'sale'=>rand(0,1),
            'late'=>rand(0,1),
            'stock'=>rand(0,1),
            'returned'=>rand(0,1),
            'date_start' => now(),
            'date_end' => now()->addMonth(),
            'service_id' => Service::where('active',1)->inRandomOrder()->first()->id,
            'unit_id'=> Unit::where('active',1)->inRandomOrder()->first()->id,
        ];
    }


    public function getOfferData($isOffer,$price): array
    {
        if($isOffer==1){
            return [
                'offer_price'=>$price + rand(1,100),
                'offer_amount'=>null,
                'offer_percent'=>null,
            ];
        }else{
            return [
                'offer_price'=>null,
                'offer_amount'=>null,
                'offer_percent'=>null,
            ];
        }
    }

    public function getShippingData($isShipping): array
    {
        if($isShipping==1){
            return [
                'shipping_cost'=>rand(1,100),
            ];
        }else{
            return [
                'shipping_cost'=>0,
            ];
        }
    }

    public function getChlidrenData($price,$offer,$parentId,$sizeId,$count){
        $data=[];
        for ($i=0; $i < $count; $i++) {
            $data[]=array_merge($this->getOfferData($offer,$price),[
            'price'=>$price,
            'amount'=>rand(50,100),
            'offer'=>$offer,
            'parent_id'=>$parentId,
            'size_id'=>$sizeId
            ]);

        }

        return $data;
    }

    public function getCategoryData($count,$service_id): array
    {
        return Category::where('service_id',$service_id)->active()
                       ->inRandomOrder()
                       ->limit($count)
                       ->pluck('id')
                       ->toArray();
    }






}
