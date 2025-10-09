<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends MainModel
{
    protected $fillable = [
        'name', 'content', 'code', 'type', 'discount', 'max_discount', 'min_order',
        'user_limit', 'use_limit', 'use_count', 'date_start', 'date_expire',
        'day_start', 'day_expire', 'order_id', 'finish', 'active'
    ];


   public function scopeActiveCoupons($query)
   {
       return $query->where('active', 1)->where('finish', 0)
       ->where(function($q) {
           $q->whereColumn('use_count', '<', 'use_limit');
       })
       ->where(function($q) {
           $q->whereNull('date_start')->orWhere('date_start', '<=', now());
       })->where(function($q) {
           $q->whereNull('date_expire')->orWhere('date_expire', '>=', now());
       })->where(function($q) {
           $q->whereNull('day_start')->orWhere('day_start', '<=', now()->toDateString());
       })->where(function($q) {
           $q->whereNull('day_expire')->orWhere('day_expire', '>=', now()->toDateString());
       });
   }
   
   public function orders()
   {
       return $this->hasMany(Order::class);
   }


}
