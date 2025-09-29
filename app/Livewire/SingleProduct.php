<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;


class SingleProduct extends Component
{
    public $related_products;
    public function render()
    {
        return view('livewire.single-product');
    }

    public function addToCart($product_id){
        if(auth()->user()){
            $carts=Cart::where('user_id',auth()->user()->id)->get();
            foreach ($carts as $cart){
                if($cart->product_id==$product_id){
                    Cart::where('product_id',$product_id)->delete();
                }
            }
            $cart=Cart::create([
                'user_id'=>auth()->user()->id,
                'product_id'=>$product_id,
                'qty'=>1
            ]);
            Product::where('id',$cart->product_id)->update([
                'statue'=>'is added to cart',
                'user_of_product_id'=>auth()->user()->id
            ]);
        }else{
            return redirect()->route('login');
        }

    }
}
