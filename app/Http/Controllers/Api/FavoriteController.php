<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\Api\ToggleWishlistRequest;
use App\Http\Resources\Api\FavoriteCollection;
use App\Http\Resources\Api\ProductCollection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends MainController
{

    public function index()
    {
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $favorites=$user->favorites()->with('product')->where('favorite','yes')->paginate($this->perPage);

        return $this->sendData(new FavoriteCollection($favorites), __('site.favorites'));
    }

    public function toggle(ToggleWishlistRequest $request)
    {
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $product=Product::filter()->where('id',$request->product_id)->first();
        if(! $product){
            return $this->messageError(__('api.product_not_found'));
        }
        $favorite=$user->favorites()->where('product_id',$request->product_id)->first();
        if($favorite){
            $favorite->update(['favorite'=>$favorite->favorite=='yes'?'no':'yes']);
            $message=$favorite->favorite=='no'?'site.wishlist_removed':'site.wishlist_added';
            return $this->messageSuccess(__($message ));
        }else{
            $user->favorites()->create([
                'product_id'=>$request->product_id,
                'favorite'=>'yes'
            ]);
            return $this->messageSuccess(__('site.wishlist_added'));
        }
      
    }





}
