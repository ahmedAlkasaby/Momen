<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
class ProductsPagiate extends Component
{
    // public $products;
    public $search;
    public function render()
    {
        // $this->products=Product::where('name','like','%'.$this->search.'%')->orWhere('price','like','%'.$this->search.'%')->orWhere('selling_price','like','%'.$this->search.'%')->paginate(10);
        $products=Product::where('name','like','%'.$this->search.'%')->orWhere('price','like','%'.$this->search.'%')->orWhere('selling_price','like','%'.$this->search.'%')->paginate(5);
        return view('livewire.products-pagiate',compact('products'));
    }
}
