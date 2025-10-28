<?php

namespace App\Models;

use App\Scopes\ProductScope;
use Illuminate\Support\Facades\Auth;



class Product extends MainModel
{
    use ProductScope;   
    protected $fillable = [
        'code',
        'link',
        'name',
        'content',
        'image',
        'video',
        'background',

        //offer
        'offer_type',
        'offer_price',
        'offer_amount',
        'offer_amount_add',
        'offer_percent',


        // price
        'price',
        'price_start',
        'price_end',
        'shipping',


        // order limits
        'start',
        'skip',
        'order_limit',
        'max_order',

        // status flags
        'active',
        'is_stock',
        'is_filter',
        'is_offer',
        'is_new',
        'is_special',
        'is_size',
        'is_color',
        'is_shipping_free',
        'is_returned',

        // not uses 
        'is_late',
        'is_sale',
        'is_max',

        // dates
        'date_start',
        'date_end',


        // foreign keys
        'unit_id',
        'brand_id',
        'size_id',
        'color_id',
        'parent_id',

        // order
        'order_id',

        // rate
        'rate_count',
        'rate_all',
        'rate'
    ];

    protected $searchable = [
        'name',
        'content',
        'code',
        'price'
    ];




    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = date('Y-m-d H:i:00', strtotime($value));
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = date('Y-m-d H:i:00', strtotime($value));
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id')->withTimestamps();
    }





    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }



    public function parentCartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function childCartItems()
    {
        return $this->hasMany(CartItem::class, 'product_child_id');
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }



    public function getAllCartItemsAttribute()
    {
        return $this->parentCartItems->merge($this->childCartItems);
    }



    public function countInCart(): int
    {
        $userId = Auth::guard('api')->id();
        if ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            if ($cart) {
                return $this->all_cart_items->where('cart_id', $cart->id)
                    ->sum('amount');
            }
        }
        return 0;
    }

    public function checkProductInCart(): bool
    {
        $userId = Auth::guard('api')->id();
        if (!$userId) return false;
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) return false;
        return $this->all_cart_items->where('cart_id', $cart->id)->isNotEmpty();
    }

    public function checkProductInFavorites()
    {
        $UserId = Auth::guard('api')->id();
        if (!$UserId) return 'no';
        return $this->favorites()->where('user_id', $UserId)->first()->favorite ?? 'no' ;
    }


    public function productIdInCart()
    {
        $userId = Auth::guard('api')->id();
        if ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) return 0;
            $cartItem = $this->all_cart_items->where('cart_id', $cart->id)->first();
            return $cartItem ? $cartItem->id : 0;
        }
        return 0;
    }



    public function deleteChildrenOldWhenNotSendInUpdate()
    {
        if ($this->children()->count() > 0 && !request()->has('children')) {

            $this->children()->delete();
        }
    }
}
