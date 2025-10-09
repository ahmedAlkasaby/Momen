<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\SettingFacade as AppSettings;


class OrderItem extends MainModel
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_child_id',
        'offer_price',
        'price',
        'amount',
        'price_addition',
        'amount_addition',
        'offer_amount',
        'offer_amount_add',
        'free_amount',
        'total_amount',
        'shipping',
        'total',
        'total_price',
        'is_return',
        'return_at'
    ];

    public function setIsReturnAttribute($value)
    {
        $product = Product::find($this->product_id);

        $this->attributes['is_return'] = $product?->is_returned ?? 0;
    }

    public function setReturnAtAttribute($value)
    {
        $product = Product::find($this->product_id);
        $returnPeriodDays = (int) AppSettings::get('return_period_days',14);
        $this->attributes['return_at'] = ($product?->is_returned==1) && isset($returnPeriodDays)
            ? now()->addDays((int) AppSettings::get('return_period_days'))
            : null;
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productChild()
    {
        return $this->belongsTo(Product::class, 'product_child_id','id');
    }
}
