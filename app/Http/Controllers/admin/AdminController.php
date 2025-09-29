<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Notification;


class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function sales(){
        $sales=Sale::orderBy('id','desc')->get();
        $products=Product::get();
        return view('admin.sales.index',compact('sales'),compact('products'));
    }

    public function create_notification($sale_id){

        return view('admin.sales.sendEmail',compact('sale_id'));
    }

    public function store_notification(Request $request,$sale_id){
        $request->validate([
            'greeting'=>'required|string',
            'body'=>'required|string',
            'action_text'=>'required|string',
            'action_url'=>'required|string',
            'end_part'=>'required|string'
        ]);
        $sale=Sale::find($sale_id);
        $user_id=$sale->user->id;
        $user=User::find($user_id);

        $details=[
            'greeting'=>$request->greeting,
            'body'=>$request->body,
            'action_text'=>$request->action_text,
            'action_url'=>$request->action_url,
            'end_part'=>$request->end_part
        ];

        Notification::send($user,new SendEmailNotification($details));
        return  redirect()->back()->with('message','تمت الارسال بنجاح');
    }


    public function cupboard(){
        $sales=Sale::orderBy('id','desc')->get();
        $cupboard=0;
        $gains=0;
        foreach($sales as $s){

            $product=Product::where('id',$s->product_id)->first();
            $cupboard+=($s->qty*$product->selling_price);
            $gains+=(($s->qty*$product->selling_price)-($s->qty*$product->price));
        }
        return view('admin.sales.cupboard',compact('cupboard'),compact('gains'));
    }

    

}
