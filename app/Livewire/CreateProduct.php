<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Str;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $categories;
    public $name;
    public $qty;
    public $price;
    public $selling_price;
    public $image;
    public $category_id;
    public $description;
    public $short_description;
    public $showing;
    public $trend;

    public $img_path;

    public $message='';


    public function render()
    {
        return view('livewire.create-product');
    }

    public function save(){
        $this->validate([
            'name'=>'required|min:3',
            'qty'=>'required|integer',
            'price'=>'required|integer',
            'selling_price'=>'required|integer',
            'image'=>'required|image|max:2048',
            'category_id'=>'required'
        ]);
        $this->img_path=$this->image->store('imgs_categories','public');

        // $this->image=$image;
        if($this->showing==true){
            $this->showing=1;
        }else{
            $this->showing=0;
        }

        if($this->trend==true){
            $this->trend=1;
        }else{
            $this->trend=0;
        }

        $slug = Str::of($this->name.uniqid())->slug('-');


        Product::create([
            'name'=>$this->name,
            'qty'=>$this->qty,
            'price'=>$this->price,
            'selling_price'=>$this->selling_price,
            'image'=>$this->img_path,
            'category_id'=>$this->category_id,
            'description'=>$this->description,
            'short_description'=>$this->short_description,
            'showing'=>$this->showing,
            'trend'=>$this->trend,
            'slug'=>$slug
        ]);

        $this->message='تمت اضافه المنتج بنجاح';


    }

    public function close_message(){
        $this->message='';
    }


}
