<?php

namespace App\Http\Resources\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        $auth=Auth()->guard('api')->user();
        $cart=Cart::where('user_id',$auth->id)->first();
        return [
            'cart_items' => $this->collection,
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'total'=>$cart->cartItems->sum('total'),
            'total_price'=>$cart->cartItems->sum('total_price'),
            'total_items'=>$cart->cartItems->count(),
            
        ];
    }
}
