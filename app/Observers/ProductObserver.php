<?php

namespace App\Observers;

use App\Models\CartItem;
use App\Models\Product;
use App\Facades\SettingFacade as AppSettings;


class ProductObserver
{
    public function created(Product $product)
    {
        if ($product->parent_id != null) {
            $productParent = Product::find($product->parent_id);
            $productParent->updateQuietly([
                'is_size' => $productParent->children->where('size_id', '!=', null)->count() > 0 ? 1 : 0,
                'is_color' => $productParent->children->where('color_id', '!=', null)->count() > 0 ? 1 : 0,
                'price_start' => $productParent->children->min('price') ?? 0,
                'price_end' => $productParent->children->max('price') ?? 0,
            ]);
        }
    }

    public function updated(Product $product): void
    {
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


    protected function updateCartItems($productId, $column, $price, $offerPrice, $offerAmount, $offerAmountAdd, $shipping, $isReturned)
    {
        CartItem::where($column, $productId)
            ->chunkById(100, function ($items) use ($price, $offerPrice, $offerAmount, $offerAmountAdd, $shipping, $isReturned) {

                foreach ($items as $item) {

                    $freeAmount = 0;
                    if ($offerAmount > 0 && $offerAmountAdd > 0) {
                        $freeAmount = floor($item->amount / $offerAmount) * $offerAmountAdd;
                    }

                    $totalAmount = $item->amount + $freeAmount;


                    $total = $offerPrice > 0 ? $offerPrice : $price * $totalAmount;
                    $totalPrice = $price * $item->amount;
                    $returnPeriodDays = (int) AppSettings::get('return_period_days', 14);

                    $returnAt = $isReturned && isset($returnPeriodDays) ?
                    now()->addDays((int) AppSettings::get('return_period_days'))
                   : null;

                    $item->update([
                        'price' => $price,
                        'offer_price' => $offerPrice,
                        'offer_amount' => $offerAmount,
                        'offer_amount_add' => $offerAmountAdd,
                        'free_amount' => $freeAmount,
                        'total_amount' => $totalAmount,
                        'total' => $total,
                        'total_price' => $totalPrice,
                        'shipping' => $shipping,
                        'is_return' => $isReturned,
                        'return_at' => $returnAt
                    ]);
                }
            });
    }
}
