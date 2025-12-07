<?php

namespace App\Helpers;

use App\Models\Product;

class HomeHelper
{
    public static function getHomeSectionFormatWeb($title,$products,$route): array
    {
        return [
            'title'=>$title ,
            'products'=>$products,
            'route'=>$route
        ];
    }
    

    
}