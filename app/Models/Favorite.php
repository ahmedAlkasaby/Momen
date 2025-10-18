<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends MainModel
{
    protected $fillable = [
        'user_id',
        'product_id',
        'favorite',
    ];
}
