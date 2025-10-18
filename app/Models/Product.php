<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;



class Product extends MainModel
{
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

    public function getAllCartItemsAttribute()
    {
        return $this->parentCartItems->merge($this->childCartItems);
    }



    public function scopeActiveProducts($query)
    {
        return $query
            ->where('active', 1)
            ->where('is_stock', 1)
            ->orderNo();
    }




    public function scopeApplyBasicFilters($query, $request, $type_app)
    {
        $query->orderNo();
        $query->whereNull('parent_id');
        if ($type_app == 'app') {
            $query->activeProducts();
        } else {
            if ($request->filled('active') && $request->active != 'all') {
                $query->where('active', $request->active);
            }
            if ($request->filled('is_stock') && $request->is_stock != 'all') {
                $query->where('is_stock', $request->is_stock);
            }
        }
        return $query;
    }





    public function scopeApplyCategoryFilter($query, $request)
    {
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        return $query;
    }

    public function scopeApplyPriceFilters($query, $request)
    {
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query;
    }










    public function scopeApplyDateFilters($query, $request)
    {
        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        return $query;
    }





    public function scopeApplySorting($query, $request)
    {
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'latest':
                    $query->orderByDesc('id');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
                case 'highest_price':
                    $query->orderBy('price', 'desc');
                    break;
                case 'lowest_price':
                    $query->orderBy('price', 'asc');
                    break;
            }
        }
        return $query;
    }






    public function scopeFilter($query, $request = null, $type_app = 'app')
    {
        $request = $request ?? request();



        $filters = $request->only([
            // relations
            'brand_id',
            'unit_id',
            'color_id'
            // status flags
            ,
            'active',
            'is_stock',
            'is_filter',
            'is_offer',
            'is_new',
            'is_special',

            'is_size',
            'is_color',
            'is_shipping_free',
            'is_returned'
        ]);


        return $query
            ->applyBasicFilters($request, $type_app)
            ->mainSearch($request->input('search'))
            ->mainApplyDynamicFilters($filters)
            ->applyCategoryFilter($request)
            ->applyPriceFilters($request)
            ->applySorting($request)
            ->applyDateFilters($request)
        ;
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




    // public function reviews()
    // {
    //     return $this->morphMany(Review::class, 'reviewable');
    // }

    // public function activeReviews()
    // {
    //     return $this->morphMany(Review::class, 'reviewable')->where('active', true);
    // }

    // public function averageRating()
    // {
    //     return $this->reviews->where('active', true)->avg('rating') ?? 0;
    // }



    public function deleteChildrenOldWhenNotSendInUpdate()
    {
        if ($this->children()->count() > 0 && !request()->has('children')) {

            $this->children()->delete();
        }
    }
}
