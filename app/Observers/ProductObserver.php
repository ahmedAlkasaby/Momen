<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function created(Product $product)
    {
        if($product -> parent_id != null){
            $productParent=Product::find($product -> parent_id);
            $productParent->updateQuietly([
                'is_size' => $productParent->children->where('size_id','!=',null)->count() > 0 ? 1 : 0,
                'is_color' => $productParent->children->where('color_id','!=',null)->count() > 0 ? 1 : 0,
                'price_start'=>$productParent->children->min('price') ?? 0,
                'price_end'=>$productParent->children->max('price') ?? 0,
            ]);
        }
    }
}
