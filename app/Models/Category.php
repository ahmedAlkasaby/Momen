<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'image',
        'description',
        'short_description',
        'showing',
        'trend',
        'slug',
        'qty'
    ];


        public function products()
        {
            return $this->hasMany(product::class);
        }

}
