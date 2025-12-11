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




    // public function setDateStartAttribute($value)
    // {
    //     $this->attributes['date_start'] = date('Y-m-d H:i:00', strtotime($value));
    // }

    // public function setDateEndAttribute($value)
    // {
    //     $this->attributes['date_end'] = date('Y-m-d H:i:00', strtotime($value));
    // }


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
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
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
        return $this->favorites()->where('user_id', $UserId)->first()->favorite ?? 'no';
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

    public function isFav()
    {
        $userId = Auth::id();
        if (!$userId) return false;

        $fav = $this->favorites()->where('user_id', $userId)->first();

        return $fav && $fav->favorite === 'yes';
    }



    public function deleteChildrenOldWhenNotSendInUpdate()
    {
        if ($this->children()->count() > 0 && !request()->has('children')) {

            $this->children()->delete();
        }
    }

    public static function getProductOfFlags($flag, $perPage = 10)
    {
        return Product::with(['unit', 'brand', 'children.color', 'children.size', 'children.images'])
            ->where($flag, 1)
            ->filter()
            ->paginate($perPage);
    }

    public function getWebModalData()
    {
        return [
            'id' => $this->id,
            'name' => $this->nameLang(),
            'image' => $this->children->first()->images->first()->image ?? asset('placeholder.png'),
            'price' => $this->children->first()->price,
            'offer_price' => $this->children->first()->offer_price,
            'children' => $this->children->map(fn($child) => [
                'id' => $child->id,
                'name' => $child->nameLang(),
                'price' => $child->price,
                'offer_price' => $child->offer_price,
                'color_id' => $child->color_id,
                'size_id' => $child->size_id,
                'order_limit' => $child->order_limit,
                'max_order' => $child->max_order,
                'is_offer' => $child->is_offer,
                'images' => $child->images->map(fn($img) => asset($img->image)),
            ])
                ->values(),

            'colors' => $this->children
                ->map(fn($child) => $child->color)
                ->filter()
                ->unique('id')
                ->map(fn($c) => [
                    'id' => $c->id,
                    'name' => $c->nameLang(),
                    'code' => $c->code,
                ])
                ->values(),

            // Sizes
            'sizes' => $this->children
                ->map(fn($child) => $child->size)
                ->filter()
                ->unique('id')
                ->map(fn($s) => [
                    'id' => $s->id,
                    'name' => $s->nameLang(),
                ])
                ->values(),
        ];
    }
}
