<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Livewire\Attributes\On;


class Shopping extends Component
{

    public $products;

    public $categories;

    public $id_of_categories;

    public function __construct(){
        $this->id_of_categories=1000;
        $this->categories=Category::get();

        $this->products=Product::where('showing',1)->get();
        foreach($this->products as $p){
            if($p->qty<=1){
                Product::where('id',$p->id)->delete();
            }
        }
    }


    public function render()
    {
        return view('livewire.shopping');
    }

    public function category($category_id){
        $this->id_of_categories=$category_id;
        $this->products=Product::where('category_id',$category_id)->get();
        foreach($this->products as $p){
            if($p->qty<=1){
                Product::where('id',$p->id)->delete();
            }
        }
    }

    public function all_of_products(){
        $this->id_of_categories=1000;

        $this->products=Product::where('showing',1)->get();

    }

    public function addToCart($product_id){
        if(auth()->user()){
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
                'statue'=>'is added to cart'
            ]);
        }else{
            return redirect()->route('login');
        }

    }


}
