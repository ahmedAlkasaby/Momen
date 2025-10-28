<?php

namespace App\Traits;

use App\Facades\SettingFacade as AppSettings;
use App\Models\CartItem;
use App\Models\Product;




Trait ProductObserverTrait
{
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


    


    public function updateProductParentAfterChildChange($parentId = null)
    {
        if ($parentId != null) {
            $productParent = Product::find($parentId);
            $isSize = $productParent->children()->whereHas('sizes')->exists();

            $productParent->update([
                'is_size' => $isSize ? 1 : 0,
                'is_color' => $productParent->children->where('color_id', '!=', null)->count() > 0 ? 1 : 0,
                'price_start' => $productParent->children->min('price') ?? 0,
                'price_end' => $productParent->children->max('price') ?? 0,
            ]);
        }
    }
}