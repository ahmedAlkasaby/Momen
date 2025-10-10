<?php

namespace App\Models;

use App\Enums\StatusOrderEnum;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';    
    protected $fillable = [
        'user_id',
        'order_id',
        'status',
        'user_type'
    ];

    protected $casts = [
        'status' => StatusOrderEnum::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
