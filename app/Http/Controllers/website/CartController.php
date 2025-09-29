<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Sale;
use App\Models\Product;



class CartController extends Controller
{
    public function store(Request $request){
        $carts=Cart::where('user_id',auth()->user()->id)->get();
        // الهدف من foreach دي اما ميكنش في الكارت مثلا كيلو طماطم وكمان كارت تانيه فيها اتنين كيلو طمام
        foreach ($carts as $cart){
            if($cart->product_id==$request->product_id){
                Cart::where('product_id',$request->product_id)->delete();
            }
        }
        if ($request->qty>0){
            Cart::create([
                'product_id'=>$request->product_id,
                'user_id'=>auth()->user()->id,
                'qty'=>$request->qty
            ]);
        }
        return redirect()->back()->with('message','تم تخزين البيانات بنجاح');
    }

    public function show(){
        $carts=Cart::where('user_id',auth()->user()->id)->get();
        return view('website.cart',compact('carts'))->with('data','cart');
    }

    public function edit($cart_id){
        $cart=Cart::find($cart_id);
        return view('website.editcart',compact('cart'))->with('data','cart');
    }

    public function update(Request $request,$id){
        Cart::where('id',$id)->update([
            'product_id'=>$request->product_id,
            'user_id'=>auth()->user()->id,
            'qty'=>$request->qty
        ]);

         return redirect()->route('cart.edit',['user_id'=>auth()->user()->id]);
    }


    public function delete($id){
        $cart=Cart::find($id);
        Product::where('id',$cart->product_id)->update([
            'statue'=>'null'
        ]);
        Cart::where('id',$id)->delete();
        return back()->with('success','تم الحدف البيانات بنجاح');
    }

    // public function check_out($user_id){
    //     $carts=Cart::where('user_id',$user_id)->get();
    //     return view('website.check_out',compact('carts'))->with('data','check_out');
    // }

    public function selling_success(){
        $carts=Cart::where('user_id',auth()->user()->id)->get();
        foreach($carts as $cart){
            $product=Product::where('id',$cart->product_id)->first();
            $newQty=$product->qty-$cart->qty;
            Product::where('id',$product->id)->update([
                'qty'=>$newQty,
                'statue'=>'null',
                'user_of_product_id'=>0
            ]);
            Sale::create([
                'product_id'=>$cart->product_id,
                'user_id'=>$cart->user_id,
                'qty'=>$cart->qty
            ]);
        }

        Cart::where('user_id',auth()->user()->id)->delete();
         return redirect()->back()->with('message','تم عمليه الشراء بنجاح ');
    }


}
