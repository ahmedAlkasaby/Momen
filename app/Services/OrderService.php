<?php

namespace App\Services;

use App\Helpers\OrderNotificationData;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService{

    protected $firebaseNotification;

    public function __construct(FirebaseNotificationService $firebaseNotification){
        $this->firebaseNotification=$firebaseNotification;

    }

    public function getShippingAddress()
    {
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $address=$user->addresses()->where('active',1)->first();
        $shipping=$address->city->shipping;
        if ($address->region_id){
            $shipping += $address->region->shipping;
        }
        return $shipping;
    }

    public function getDiscount($productId)
    {
        $product=Product::find($productId);
        if (! $product->offer){
            return 0;
        }
        if ($product->offer_price){
            return $product->offer_price-$product->price;
        }elseif ($product->offer_amount) {
            $amount=$product->offer_amount;
            $price=$product->price;
            $totalPrice=(100*$price)/(100-$amount);
            return ($totalPrice-$price);
        }elseif ($product->offer_percent){
            return $product->offer_percent;
        }
    }

    public function createOrderItems($items,$order){
        foreach ($items as $item) {
           $order->orderItems()->create([
               'product_id'=>$item->product_id,
               'amount'=>$item->amount,
               'price'=>$item->product->price,
               'discount'=>$this->getDiscount($item->product_id),
               'shipping_cost' => $item->product->shipping_cost ?? 0,
           ]);
           $product = Product::find($item->product_id);
           $product->decrement('amount', $item->amount);
       }
    }


    public function canCreateOrder()
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $totalPrice=$user->totalPriceInCart();
        $setting=Setting::where('active',1)->first();


        if ($user->cartItems()->count() == 0) {
            return __('api.cart_is_empty');
        }
        if ($user->addresses()->count() == 0) {
            return __('api.address_not_found');
        }

        if($totalPrice < $setting->min_order){
            return __('api.min_order',['min_order' => $setting->min_order]);
        }

        return true;
    }


    public function getAddressId(){
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $address=$user->addresses()->where('active',1)->first();
        return $address->id;
    }

    public function notificationAfterOrder($statusOrder='request')
    {
        $admins=User::where('type','admin')->where('notify',1)->where('active',1)->get();
        $notificationData=OrderNotificationData::getData($statusOrder);
        Notification::send($admins,$notificationData['title_ar'],$notificationData['title_en'],$notificationData['body_ar'],$notificationData['body_en']);
        $dataFirebase = [
            'title' => json_encode([
                'ar' => $notificationData['title_ar'],
                'en' => $notificationData['title_en'],
            ]),
            'body' => json_encode([
                'ar' => $notificationData['body_ar'],
                'en' => $notificationData['body_en'],
            ]),
        ];
        $user=Auth::guard('api')->user();

        foreach ($user->devices as $device) {
            $this->firebaseNotification->sendNotificationWithDevice(
                $device,
                $notificationData['title_ar'],
                $notificationData['body_ar'],
                $dataFirebase,
            );
        }

    }

    
    public function getOrderPrice()
    {
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $totalPrice=$user->totalPriceInCart();
        return $totalPrice;
    }

    public function getOrderDiscount()
    {
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $totalDiscount = 0;
        foreach ($user->cartItems as $item) {
            $totalDiscount += $this->getDiscount($item->product_id);
        }
        return $totalDiscount;
    }

    public function getOrderShippingProducts(){
        $auth=Auth::guard('api')->user();
        $user=User::find($auth->id);
        $totalShipping = 0;
        foreach ($user->cartItems as $item) {
            $totalShipping += $item->product->shipping_cost;
        }
        return $totalShipping;
    }


    public function getTotalOrderPrice(){
        $totalPrice=$this->getOrderPrice();
        $totalDiscount=$this->getOrderDiscount();
        $totalShippingProducts=$this->getOrderShippingProducts();
        $totalShippingAddress=$this->getShippingAddress();
        $total=($totalPrice - $totalDiscount) + $totalShippingProducts + $totalShippingAddress;
        return $total;
    }
}

