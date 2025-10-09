<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Facades\SettingFacade as AppSettings;
use App\Models\Cart;

class CartItemsService
{
    public function canPlaceProductInCart($productId, $amount, $userId)
    {
        $product = Product::find($productId);


        if ($product->children()->exists()) {
            return __('api.you_must_choose_from_children');
        }
        if (! $product->active) {
            return __('api.product_not_active');
        }

        if ($product->is_stock == 0) {
            return __('api.product_not_available_amount');
        }

        if ($amount > $product->max_order) {
            return __('api.max_order', ['max_order' => $product->max_order]);
        }
        if ($amount < $product->order_limit) {
            return __('api.order_limit', ['order_limit' => $product->order_limit]);
        }


        if (! $this->checkMaxOrderInSetting($userId, $amount, $productId)) {
            return __('api.max_order_in_setting', ['max_order' => AppSettings::get('max_order')]);
        }

        return true;
    }


    public function checkMaxOrderInSetting($userId, $amount, $productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }

        $maxOrderValue = AppSettings::get('max_order');
        $totalPriceForThisProduct = $product->price * $amount;

        if ($totalPriceForThisProduct > $maxOrderValue) {
            return false;
        }

        $cart = Cart::with('cartItems.product')
            ->where('user_id', $userId)
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return true;
        }

        $totalCartValue = $cart->cartItems->sum(function ($item) {
            return $item->price * $item->amount;
        });

        return ($totalPriceForThisProduct + $totalCartValue) <= $maxOrderValue;
    }


    public function checkProductInCart($productId, $userId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (! $cart) {
            return false;
        }

        return $cart->cartItems()
            ->where(function ($query) use ($productId) {
                $query->where('product_id', $productId)
                    ->orWhere('product_child_id', $productId);
            })
            ->exists();
    }


    public function getDataCartItem($productId,$amount){
        $data=[];
        $product = Product::find($productId);
        if($product ->parent_id){
            $data['product_id']=$product->parent_id;
            $data['product_child_id']=$product->id;
        }else{
            $data['product_id']=$product->id;
            $data['product_child_id']=null;
        }
        $data['offer_price']=$product->offer_price;
        $data['price']=$product->price;
        $data['amount']=$amount;
        $data['offer_amount']=$product->offer_amount;
        $data['offer_amount_add']=$product->offer_amount_add;
        $data['free_amount']=$this->calculateFreeAmount($productId,$amount);
        $data['total_amount']=$data['amount'] + $data['free_amount'];
        $data['total']=$data['offer_price'] > 0  ? ($data['offer_price'] * $data['total_amount'] ): ( $data['price'] * $data['total_amount']);
        $data['total_price']=$product->price * $amount;
        $data['shipping']=$product->shipping;
        $data['is_return']=$product->is_returned;
        $returnPeriodDays = (int) AppSettings::get('return_period_days',14);    
        $data['return_at']=$data['is_return']==1 && isset($returnPeriodDays) ?
        now()->addDays((int) $returnPeriodDays)
       : null;
        return $data;

    }

    public function calculateFreeAmount($productId,$amount){
        $product = Product::find($productId);
        if($product->offer_amount>0 && $product->offer_amount_add>0){
            $freeAmount=intval($amount / $product->offer_amount) * $product->offer_amount_add;
            return $freeAmount;
        }
        return 0;
    }
}
