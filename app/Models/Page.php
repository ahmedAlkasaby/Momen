<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends MainModel
{
    protected $fillable = [
        'name',
        'title',
        'content',
        'link',
        'image',
        'type',
        'page_type',
        'active',
        'feature',
        'order_id',
        'product_id',
    ];
}
