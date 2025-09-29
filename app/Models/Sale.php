<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Sale extends Model
{
    use HasFactory,Notifiable;
    protected $fillable=[
        'product_id',
        'qty',
        'user_id'
    ];


        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
}
