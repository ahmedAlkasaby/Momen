<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'image',
        'slug',
        'description',
        'short_description',
        'price',
        'selling_price',
        'trend',
        'showing',
        'category_id',
        'qty',
        'statue',
        'user_of_product_id'
    ];


        public function category()
        {
            return $this->belongsTo(Category::class);
        }

}
