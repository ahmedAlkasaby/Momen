<?php

namespace App\Models;

use App\Enums\StatusOrderEnum;
use Illuminate\Database\Eloquent\Model;

class Order extends MainModel
{
    protected $fillable = [
        'user_id',
        'delivery_id',
        'cancel_by',
        'cancel_date',
        'address_id',
        'payment_id',
        'region_id',
        'city_id',

        'coupon_id',
        'coupon_type',
        'coupon_discount',

        'tax',
        'fees',
        'price',
        'shipping',
        'discount',
        'price_returned',
        'total',

        'paid',
        'wallet',
        'total_paid',
        'remaining',
        'is_paid',


        'status',

        'delivery_time_id',


        'note',
        'delivery_note',
        'admin_note',
        'reject_note',

        'is_read',
    ];
    protected $cast=[
        'status'=>StatusOrderEnum::class
    ];
   

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery()
    {
        return $this->belongsTo(User::class);
    }
    public function deliveryTime()
    {
        return $this->belongsTo(DeliveryTime::class);
    }

    public function cancelBy()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItemReturns()
    {
        return $this->hasMany(OrderItemReturn::class);
    }
}
