<?php

namespace App\Observers;

use App\Facades\SettingFacade as AppSettings;
use App\Models\CartItem;
use App\Models\Product;
use App\Traits\ProductObserverTrait;


class ProductObserver
{
    use ProductObserverTrait;
    public function created(Product $product)
    {
        $this->updateProductParentAfterChildChange($product->parent_id);
    }

   

    public function updated(Product $product): void
    {
        $this->updateProductParentAfterChildChange($product->parent_id);

        if($product->wasChanged(['active','is_stock'])) {
            if($product->active==0 || $product->is_stock==0) {
                CartItem::where('product_id', $product->id)
                    ->orWhere('product_child_id', $product->id)
                    ->delete();
            }
        }
        if ($product->wasChanged([
            'price',
            'offer_price',
            'offer_amount',
            'offer_amount_add',
            'shipping',
            'is_returned'
        ])) {

            $newPrice = $product->price;
            $newOfferPrice = $product->offer_price;
            $offerAmount = $product->offer_amount ?? 0;
            $offerAmountAdd = $product->offer_amount_add ?? 0;
            $shipping = $product->shipping ?? 0;
            $isReturned = $product->is_returned ?? 0;

            $this->updateCartItems(
                $product->id,
                'product_id',
                $newPrice,
                $newOfferPrice,
                $offerAmount,
                $offerAmountAdd,
                $shipping,
                $isReturned
            );

            $this->updateCartItems(
                $product->id,
                'product_child_id',
                $newPrice,
                $newOfferPrice,
                $offerAmount,
                $offerAmountAdd,
                $shipping,
                $isReturned
            );
        }
    }

    public function deleted(Product $product)
    {
        $this->updateProductParentAfterChildChange($product->parent_id);
    }

    public function restored(Product $product)
    {
        $this->updateProductParentAfterChildChange($product->parent_id);
    }


   
}
