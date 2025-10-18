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
        $data = [
            'categories',
            'unit',
            'color',
            'size',
            'brand',
            'parent',
            'favorites',
        ];
        $products = Product::with($data)
            ->filter($request)->paginate($this->perPage);

        return $this->sendDataCollection(new ProductCollection($products));
    }



    public function show(string $id)
    {

        $data = [
            'categories',
            'unit',
            'color',
            'size',
            'brand',
            'children',
            'parent',
            'favorites',
        ];

        $product = Product::with($data)->filter()
            ->where('id', $id)
            ->first();
        if (!$product) {
            return $this->sendError(__('site.not_found_product'), 404);
        }
        return $this->sendData(new ProductResource($product));
    }
}
