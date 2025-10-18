<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product_child_id' => $this->product_child_id,
            'offer_price' => $this->offer_price,
            'price' => $this->price,
            'amount' => $this->amount,
            'price_addition' => $this->price_addition,
            'amount_addition' => $this->amount_addition,
            'offer_amount' => $this->offer_amount,
            'offer_amount_add' => $this->offer_amount_add,
            'free_amount' => $this->free_amount,
            'total_amount' => $this->total_amount,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'total_price' => $this->total_price,
            'is_return' => $this->is_return,
            'return_at' => $this->return_at,
            'created_at' => formatDate($this->created_at),
            'updated_at' => formatDate($this->updated_at),
            'product' => new ProductResource($this->whenLoaded('product')),
            'product_child' => new ProductResource($this->whenLoaded('productChild')),
            'order_item_return'=>new OrderItemReturnResource($this->whenLoaded('orderItemReturn')),
            
           
        ];
    }
}
