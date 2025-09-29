<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class WebsiteController extends Controller
{
    public function home(){
        $products=Product::where('trend',1)->get();
        foreach($products as $p){
            if($p->qty<=1){
                Product::where('id',$p->id)->delete();
            }
        }
        return view('website.home',compact('products'))->with('data','home');
    }
    public function shop(){
        // $categories=Category::get();
        // $carts=cart::all();
        // $products=Product::where('showing',1)->get();
        // foreach($products as $p){
        //     if($p->qty<=1){
        //         Product::where('id',$p->id)->delete();
        //     }
        // }
        return view('website.shop')->with('data','shop');
    }

    public function category($slug){
        // $category=Category::where('slug',$slug)->first();

        // $products=Product::where('category_id',$category->id)->get();
        // foreach($products as $p){
        //     if($p->qty<=1){
        //         Product::where('id',$p->id)->delete();
        //     }
        // }

        // return view('website.category',compact('category'),compact('products'))->with('data','shop');
    }

    public function show_product($slug){
       $product= Product::where('slug',$slug)->first();
       $related_products=Product::where('category_id',$product->category_id)->get();
       return view('website.single_product',compact('product'),compact('related_products'))->with('data','shop');
    }
}
