<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;

class Carts extends Component
{

    public function render()
    {

        $carts=Cart::where('user_id',auth()->user()->id)->get();
        

        return view('livewire.carts',compact('carts'));
    }


    public function increaseQTY($cart_id){
        $cart=Cart::where('id',$cart_id)->first();
        $product_qty=$cart->product->qty;
        if($product_qty > $cart->qty){
            $cart_qty=$cart->qty;
            $cart_qty++;
            Cart::where('id',$cart_id)->update([
            'qty'=>$cart_qty
            ]);
        }
    }

    public function decreaseQTY($cart_id){
        $cart=Cart::where('id',$cart_id)->first();
        $product_qty=$cart->product->qty;
        if($cart->qty >0){
            $cart_qty=$cart->qty;
            $cart_qty--;
            Cart::where('id',$cart_id)->update([
            'qty'=>$cart_qty
            ]);
        }
    }



}



