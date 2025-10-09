<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends MainModel
{
    protected $fillable = [
        'user_id', 'delivery_id', 'cancel_by', 'cancel_date', 'address_id', 'coupon_id', 'payment_id',
        'region_id', 'city_id', 'branch_id', 'country_id', 'coupon_type', 'coupon_discount',
        'tax', 'fees', 'total_products', 'total', 'is_paid', 'rate', 'rate_comment',
        'status', 'parent_id', 'delivery_time_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery()
    {
        return $this->belongsTo(User::class);
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


}
