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
        'color',

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
    ];

    protected $searchable = [
        'name',
        'content',
        'code',
        'price'
    ];


    public function setPriceIsSizeAttribute($value)
    {
        $this->attributes['is_size'] = $this->children->where('size_id','!=',null)->count() > 0 ? 1 : 0;
    }
    public function setPriceIsColorAttribute($value)
    {
        $this->attributes['is_color'] = $this->children->where('color_id','!=',null)->count() > 0 ? 1 : 0;
    }
   
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

    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function parent()
    {
        return $this->belongsTo(Product::class,'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    // public function wishlists()
    // {
    //     return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id')->withTimestamps();
    // }

    // public function cartItems()
    // {
    //     return $this->hasMany(CartItem::class, 'product_id', 'id');
    // }

    public function scopeActiveProducts($query)
    {
        return $query
            ->where('active', 1)
            ->where('stock',1)
            ->orderNo();
    }




    public function scopeApplyBasicFilters($query, $request, $type_app)
    {
        if($type_app=='app'){
          $query->activeProducts();
        }

        $query->orderNo();
        $query->whereNull('parent_id');
        if ($request->filled('active') && $request->active != 'all') {
            $query->where('active', $request->active);
        }
        if ($request->filled('date_start')) {
            $query->whereDate('date_start', '<=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $query->whereDate('date_end', '>=', $request->date_end);
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
            'brand_id', 'unit_id','color_id'
            // status flags
             ,'active', 'is_stock', 'is_filter', 'is_offer', 'is_new', 'is_special',
             
              'is_size', 'is_color', 'is_shipping_free','is_returned'
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
            return $this->cartItems->where('user_id', $userId)
                ->sum('amount');
        }
        return 0;
    }

    public function checkProductInCart(): bool
    {
        $userId = Auth::guard('api')->id();
        if (!$userId) return false;
        return $this->cartItems->where('user_id', $userId)->isNotEmpty();
    }

    public function checkProductInWishlists(): bool
    {
        $userId = Auth::guard('api')->id();
        if (!$userId) return false;
        return $this->wishlists->where('id', $userId)->isNotEmpty();
    }


    public function productIdInCart()
    {
        $userId = Auth::guard('api')->id();
        if ($userId) {
            $cartItem = $this->cartItems->where('user_id', $userId)->first();
            return $cartItem ? $cartItem->id : 0;
        }
        return 0;
    }



    // public function amountInAllCarts()
    // {
    //     return $this->cartItems->sum('amount');
    // }


    // public function availableAmount()
    // {
    //     return $this->amount - $this->amountInAllCarts();
    // }

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
