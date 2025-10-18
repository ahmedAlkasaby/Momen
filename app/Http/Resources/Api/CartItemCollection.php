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
        
        return [
            'cart_items' => $this->collection,
        ];
    }
}
