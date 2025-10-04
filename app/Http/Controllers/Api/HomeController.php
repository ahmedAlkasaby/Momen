<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\HomeCollection;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HomeController extends MainController
{
    public function index(){
        $data=['categories','service','unit','size','brand','wishlists','cartItems'];
        $products=Product::with($data)
        ->withMin('children','price')
        ->withMax('children','price')
        ->withCount('activeReviews')
        ->withAvg('activeReviews','rating')
        ->withSum('cartItems as amount_in_all_carts', 'amount')
        ->filter()->paginate($this->perPage);

        $data=new HomeCollection($products);

        return $this->sendData($data);
    }


}
