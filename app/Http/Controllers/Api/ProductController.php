<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\MainController;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Resources\Api\ProductCollection;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends MainController
{

    public function index(ProductRequest $request)
    {
        $data = ['categories', 'service', 'unit', 'size', 'brand', 'wishlists', 'cartItems'];
        $products = Product::with($data)
            ->withMin('children', 'price')
            ->withMax('children', 'price')
            ->withCount('activeReviews')
            ->withAvg('activeReviews', 'rating')
            ->withSum('cartItems as amount_in_all_carts', 'amount')
            ->filter($request)->paginate($this->perPage);

        return $this->sendData(new ProductCollection($products));
    }



    public function show(string $id)
    {
        $data = ['categories', 'service', 'unit', 'size', 'brand', 'wishlists', 'cartItems', 'children.size', 'parent'];

        $product = Product::with($data)
            ->withMin('children', 'price')
            ->withMax('children', 'price')
            ->withCount('activeReviews')
            ->withAvg('activeReviews', 'rating')
            ->withSum('cartItems as amount_in_all_carts', 'amount')
            ->active()
            ->where('id', $id)
            ->first();
        if (!$product) {
            return $this->sendError(__('site.not_found_product'), 404);
        }
        return $this->sendData(new ProductResource($product));
    }
}
