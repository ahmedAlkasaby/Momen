<?php

namespace App\Http\Controllers\Web;

use App\Helpers\HomeHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\MainController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->setClass('home');
    }
    public function index()
    {
        $categories = Category::filter()->paginate(15);
        $newProducts = Product::getProductOfFlags('is_new',10);
        $specialProducts = Product::getProductOfFlags('is_special',10);
        $filterProducts = Product::getProductOfFlags('is_filter',10);
        $offerProducts = Product::getProductOfFlags('is_offer',10);
        $sections=[];
        $sections['newProducts']=HomeHelper::getHomeSectionFormatWeb( __('web.new_products'),$newProducts,route('products.index',['is_new'=>1]));
        $sections['specialProducts']=HomeHelper::getHomeSectionFormatWeb( __('web.special_products'),$specialProducts,route('products.index',['is_special'=>1]));
        $sections['offerProducts']=HomeHelper::getHomeSectionFormatWeb( __('web.offer_products'),$offerProducts,route('products.index',['is_offer'=>1]));
        $sections['filterProducts']=HomeHelper::getHomeSectionFormatWeb( __('web.filter_products'),$filterProducts,route('products.index',['is_filter'=>1]));
        return view('web.home.index',compact('sections','categories'));
    }
}
