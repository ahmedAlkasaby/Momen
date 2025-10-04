<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\UserResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $setting=Setting::where('active',1)->first();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'payment_id' => $this->payment_id,
            'delivery_time_id' => $this->delivery_time_id,
            'delivery_id' => $this->delivery_id,
            'shipping_address' => $this->shipping_address,
            'notes' => $this->notes,
            'status' => $this->status,
            'price'=>$this->orderPrice(),
            'discount'=>$this->orderDiscount(),
            'shipping_address'=>$this->shipping_address,
            'order_shipping_products'=>$this->orderShippingProducts(),
            'shipping'=>$this->orderShippingProducts()+$this->shipping_address,
            'delivery_cost'=>$setting->delivery_cost,

            'created_at' => formatDate($this->created_at),
            'updated_at' => formatDate($this->updated_at),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'user' => new UserResource($this->whenLoaded('user')),
            'address' => new AddressResource($this->whenLoaded('address')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'delivery_time' => new DeliveryTimeResource($this->whenLoaded('deliveryTime')),
            'delivery' => new UserResource($this->whenLoaded('delivery')),
        ];
    }
}
