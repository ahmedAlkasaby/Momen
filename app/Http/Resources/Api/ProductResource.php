<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\UnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->nameLang(),
            'description' => $this->descriptionLang(),
            'link' => $this->link,
            'code' => $this->code,
            'video' => $this->video,
            'background' => $this->background,
            'color' => $this->color,
            'image' => url($this->image),


            'price_start' => $this->children_min_price,
            'price_end'   => $this->children_max_price,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'offer_amount' => $this->offer_amount,
            'offer_percent' => $this->offer_percent,
            'shipping_cost' => $this->shipping_cost,



            'start' => $this->start,
            'skip' => $this->skip,
            'max_order' => $this->max_order,
            'amount' => $this->amount,
            'amount_in_all_carts' => $this->amount_in_all_carts ?? 0,
            'available_amount'    => $this->amount - ($this->amount_in_all_carts ?? 0),
            'active' => $this->active,
            'feature' => $this->feature,
            'new' => $this->new,
            'special' => $this->special,
            'filter' => $this->filter,
            'sale' => $this->sale,
            'late' => $this->late,
            'stock' => $this->stock,
            'free_shipping' => $this->free_shipping,
            'returned' => $this->returned,


            'reviews_count'  => $this->reviews_count ?? 0,
            'average_rating' => $this->active_reviews_avg_rating ?? 0,




            'date_start' => $this->date_start,
            'date_end' => $this->date_end,

            'service_id' => $this->service_id,
            'unit_id' => $this->unit_id,
            'brand_id' => $this->brand_id,
            'size_id' => $this->size_id,
            'parent_id' => $this->parent_id,
            'order_id' => $this->order_id,
            'in_wishlists' =>$this->whenLoaded('wishlists', function (){
                return $this->checkProductInWishlists();
            }),
            'in_cart' => $this->whenLoaded('cartItems', function () {
                return $this->checkProductInCart();
            }),
            'id_in_cart' => $this->whenLoaded('cartItems', function () {
                return $this->productIdInCart();
            }),
            'count_in_cart' => $this->whenLoaded('cartItems', function () {
                return $this->countInCart();
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'brand' => $this->whenLoaded('brand'),
            'size' => new SizeResource($this->whenLoaded('size')),
            'service' => new ServiceResource($this->whenLoaded('service')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'parent' => new ProductResource($this->whenLoaded('parent')),
            'children' => ProductResource::collection($this->whenLoaded('children')),

        ];
    }
}
