<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreCartItemsRequest;
use App\Http\Resources\Api\CartItemCollection;
use App\Http\Resources\Api\CartItemResource;
use App\Models\Cart;
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
        $cart=Cart::where('user_id',$auth->id)->first();
        if (!$cart) {
            return $this->messageError(__('site.cart_is_empty'), 404);
        }
        $cartItems = CartItem::with('product','productChild')->where('cart_id', $cart->id)->paginate($this->perPage);
        $extra = $this->cartItemsService->getExtraInCollection($cart->id);
        return $this->sendDataCollection(new CartItemCollection($cartItems), __('site.cart_items'), $extra);
    }


    public function store(StoreCartItemsRequest $request)
    {
        $auth=Auth()->guard('api')->user();

        if($this->cartItemsService->checkProductInCart($request->product_id,$auth->id)){
            $cart=Cart::where('user_id',$auth->id)->first();
            CartItem::where('product_id', $request->product_id)
            ->orWhere('product_child_id', $request->product_id)
            ->where('cart_id', $cart->id)->delete();
        }

        $result=$this->cartItemsService->canPlaceProductInCart($request->product_id,$request->amount,$auth->id);

        if($result !== true){
            return $this->messageError($result);
        }
        $cart=Cart::firstOrCreate(
            ['user_id'=>$auth->id],
            ['type'=>'cart']
        );
      
        $cart->cartItems()->create($this->cartItemsService->getDataCartItem($request->product_id,$request->amount));

        return $this->messageSuccess(__('site.cart_item_added'));

    }


    public function show(string $id)
    {
        $auth=Auth()->guard('api')->user();
        $cart=Cart::where('user_id',$auth->id)->first();
        $cartItem=CartItem::with('product','productChild')
        ->where('cart_id', $cart->id)
        ->where('id',$id)->first();
        if (!$cartItem) {
            return $this->messageError(__('site.cart_item_not_found'), 404);
        }
        return $this->sendData(new CartItemResource($cartItem), __('site.cart_item'));
    }



    public function destroy(string $id)
    {
        $auth=Auth()->guard('api')->user();
        $cart=Cart::where('user_id',$auth->id)->first();
        $cartItem=CartItem::where('cart_id', $cart->id)->where('id',$id)->first();

        if (!$cartItem) {
            return $this->messageError(__('site.cart_item_not_found'));
        }
        $cartItem->delete();
        if($cart->cartItems->count() == 0){
            $cart->delete();
        }
        return $this->messageSuccess(__('site.cart_item_deleted'));
    }
}
