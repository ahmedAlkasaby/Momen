<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Cart;

use App\Models\Category;


class ProductController extends Controller
{

    public function index()
    {
        $products=Product::orderBy('id','desc')->get();
        foreach($products as $product){
            if($product->qty==0){
                Product::where('id',$product->id)->delete();
            }
        }
        return view('admin.products.index',compact('products'));

    }


    public function create()
    {
        $categories=Category::get();
        return view('admin.products.create',compact('categories'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10',
            'price'=>'required',
            'selling_price'=>'required',
            'category_id'=>'required',
            'qty'=>'required',
        ]);

        if(is_null($request->input('showing'))){
            $showing=0;
        }else{
            $showing=1;
        }
        if(is_null($request->input('trend'))){
            $trend=0;
        }else{
            $trend=1;
        }
        $slug = Str::of($request->name.uniqid())->slug('-');

        $image=$request->file('image')->store('imgs_categories','public');
        // dd($request->qty);
        Product::create([
            'name'=>$request->name,
            'image'=>$image,
            'category_id'=>$request->category_id,
            'price'=>$request->price,
            'selling_price'=>$request->selling_price,
            'description'=>$request->description,
            'short_description'=>$request->short_description,
            'trend'=>$trend,
            'showing'=>$showing,
            'slug'=>$slug,

            'qty'=>$request->qty
        ]);
        return redirect()->route('product.index');
    }


    public function show(string $id)
    {
        $product=Product::find($id);
        return view('admin.products.show',compact('product'));

    }


    public function edit(string $id)
    {
        $product=Product::find($id);
        $categories=Category::get();

        return view('admin.products.edit',compact('product'),compact('categories'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10',
            'price'=>'required',
            'selling_price'=>'required',
            'qty'=>'required',
            'category_id'=>'required',
            'qty'=>'required',
        ]);

        if(is_null($request->input('showing'))){
            $showing=0;
        }else{
            $showing=1;
        }
        if(is_null($request->input('trend'))){
            $trend=0;
        }else{
            $trend=1;
        }
        $slug = Str::of($request->name.uniqid())->slug('-');

        $image=$request->file('image')->store('imgs_categories','public');
        Product::where('id',$id)->update([
            'name'=>$request->name,
            'image'=>$image,
            'category_id'=>$request->category_id,
            'price'=>$request->price,
            'selling_price'=>$request->selling_price,
            'description'=>$request->description,
            'short_description'=>$request->short_description,
            'trend'=>$trend,
            'showing'=>$showing,
            'slug'=>$slug,
            'qty'=>$request->qty
        ]);
        return redirect()->route('product.index');
    }


    public function destroy(string $id)
    {
        $carts=Cart::get();
        foreach($carts as $cart){
            if($cart->product_id==$id){
                Cart::where('product_id',$id)->delete();
            }
        }
        Product::where('id',$id)->delete();
        return redirect()->route('product.index');
    }
}
