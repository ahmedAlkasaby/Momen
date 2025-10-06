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
            'content' => $this->contentLang(),
            'link' => $this->link,
            'code' => $this->code,
            'video' => $this->video,
            'background' => $this->background,
            'image' => url($this->image),


            'offer_type' => $this->offer_type,
            'offer_price' => $this->offer_price,
            'offer_amount' => $this->offer_amount,
            'offer_amount_add' => $this->offer_amount_add,
            'offer_percent' => $this->offer_percent,


            'price_start' => $this->price_start,
            'price_end'   => $this->price_end,
            'price' => $this->price,
            'shipping' => $this->shipping,


            'start' => $this->start,
            'skip' => $this->skip,
            'order_limit' => $this->order_limit,
            'max_order' => $this->max_order,


            'active' => $this->active,
            'is_filter' => $this->is_filter,
            'is_offer' => $this->is_offer,
            'is_new' => $this->is_new,
            'is_special' => $this->is_special,
            'is_stock' => $this->is_stock,
            'is_shipping_free' => $this->is_shipping_free,
            'is_returned' => $this->is_returned,

            'is_size' => $this->is_size,
            'is_color' => $this->is_color,


            // 'reviews_count'  => $this->reviews_count ?? 0,
            // 'average_rating' => $this->active_reviews_avg_rating ?? 0,

            'unit_id' => $this->unit_id,
            'brand_id' => $this->brand_id,
            'size_id' => $this->size_id,
            'color_id' => $this->color_id,
            'parent_id' => $this->parent_id,
            'order_id' => $this->order_id,
            // 'in_wishlists' =>$this->whenLoaded('wishlists', function (){
            //     return $this->checkProductInWishlists();
            // }),
            'in_cart' => $this->checkProductInCart(),
            'id_in_cart' => $this->productIdInCart(),
            'count_in_cart' => $this->countInCart(),

            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'size' => new SizeResource($this->whenLoaded('size')),
            'color' => new ColorResource($this->whenLoaded('color')),
            'parent' => new ProductResource($this->whenLoaded('parent')),
            'children' => ProductResource::collection($this->whenLoaded('children')),

        ];
    }
}
