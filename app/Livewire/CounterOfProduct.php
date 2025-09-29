<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;


class CounterOfProduct extends Component
{
    public $counter;
    public $product_of_slug;
    public $message='';
    public $qty_product;

    public function render()
    {


       $product=$this->product_of_slug;

        return view('livewire.counter-of-product',compact('product'));
    }

    public function increase(){
       $product=$this->product_of_slug ;
       $product_qty=$product->qty;
       if($this->counter==$product_qty){
        return $this->counter;
       }
        $this->counter+=1;
    }

    public function decrease(){

        if($this->counter==0){
         return $this->counter;
        }
         $this->counter-=1;
     }

     public function add_to_cart(){
        if(auth()->user()){
            $product=$this->product_of_slug ;
            $carts=Cart::where('user_id',auth()->user()->id)->get();
            foreach ($carts as $cart){
             if($cart->product_id==$product->id){
                 Cart::where('product_id',$product->id)->delete();
                }
            }
             $cart=Cart::create([
                 'product_id'=>$product->id,
                 'user_id'=>auth()->user()->id,
                 'qty'=>$this->counter,

             ]);
             Product::where('id',$cart->product_id)->update([
                 'statue'=>'is added to cart',
                 'user_of_product_id'=>auth()->user()->id
             ]);

             $this->counter=0;

             $this->message='تمت اضافه المنتج الي السله';
        }else{
            return redirect()->route('login');
        }


     }

     public function closeAlert(){
        $this->message='';
     }


}
