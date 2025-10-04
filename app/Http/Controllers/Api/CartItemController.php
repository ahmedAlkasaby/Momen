<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreCartItemsRequest;
use App\Http\Resources\Api\CartItemCollection;
use App\Http\Resources\Api\CartItemResource;
use App\Models\CartItem;
use App\Models\User;
use App\Services\CartItemsService;

class CartItemController extends MainController
{
    protected $cartItemsService ;

    public function __construct(CartItemsService $cartItemsService)
    {
        $this->cartItemsService = $cartItemsService;
    }


    public function index()
    {
        $auth=Auth()->guard('api')->user();
        $cartItems = CartItem::with('product')->where('user_id', $auth->id)->paginate($this->perPage);
        return $this->sendData(new CartItemCollection($cartItems), __('site.cart_items'));
    }


    public function store(StoreCartItemsRequest $request)
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);

        if($this->cartItemsService->checkProductInCart($request->product_id,$auth->id)){
            CartItem::where('product_id', $request->product_id)->where('user_id', $auth->id)->delete();
        }

        $result=$this->cartItemsService->canPlaceProductInCart($request->product_id,$request->amount,$auth->id);

        if($result !== true){
            return $this->messageError($result);
        }

        $user->cartItems()->create($request->validated());

        return $this->messageSuccess(__('site.cart_item_added'));

    }


    public function show(string $id)
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $cartItem=$user->cartItems()->with('product')->where('id',$id)->first();
        if (!$cartItem) {
            return $this->messageError(__('site.cart_item_not_found'));
        }
        return $this->sendData(new CartItemResource($cartItem), __('site.cart_item'));
    }



    public function destroy(string $id)
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $cartItem=$user->cartItems()->where('id',$id)->first();

        if (!$cartItem) {
            return $this->messageError(__('site.cart_item_not_found'));
        }
        $cartItem->delete();
        return $this->messageSuccess(__('site.cart_item_deleted'));
    }
}
