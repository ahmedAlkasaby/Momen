<?php 
namespace App\Helpers;


class PageHelper
{
    public static function getPagesTypes()
    {
        return [
            "home",
            "about" ,
            "contact" ,
            "terms" ,
            "privacy",
            "faq"  ,
            "profile",
            "support",
        ];
    }
}