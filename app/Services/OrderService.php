<?php

namespace App\Services;

use App\Facades\SettingFacade as AppSettings;
use App\Helpers\OrderNotificationData;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class OrderService
{

    // protected $firebaseNotification;

    // public function __construct(FirebaseNotificationService $firebaseNotification)
    // {
    //     $this->firebaseNotification = $firebaseNotification;
    // }

    public function getShippingAddress($addressId)
    {
        $auth = Auth::guard('api')->user();
        $user = User::find($auth->id);
        $address = $user->addresses()->where('id', $addressId)->first();
        $shipping = $address->city->shipping;
        if ($address->region_id) {
            $shipping += $address->region->shipping;
        }
        return $shipping;
    }

    public function getDiscount($productId)
    {
        $product = Product::find($productId);
        if (! $product->offer) {
            return 0;
        }
        if ($product->offer_price) {
            return $product->offer_price - $product->price;
        } elseif ($product->offer_amount) {
            $amount = $product->offer_amount;
            $price = $product->price;
            $totalPrice = (100 * $price) / (100 - $amount);
            return ($totalPrice - $price);
        } elseif ($product->offer_percent) {
            return $product->offer_percent;
        }
    }

    public function createOrderItems($items, $order)
    {
        foreach ($items as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'amount' => $item->amount,
                'price' => $item->product->price,
                'discount' => $this->getDiscount($item->product_id),
                'shipping_cost' => $item->product->shipping_cost ?? 0,
            ]);
            $product = Product::find($item->product_id);
            $product->decrement('amount', $item->amount);
        }
    }


    public function canCreateOrder($userId)
    {
        $user = User::find($userId);
        $setting = AppSettings::all();

        if (!$user->cart || $user->cart->cartItems->isEmpty()) {
            return __('api.cart_is_empty');
        }
        $totalPrice = $user->totalPriceInCart();
        if ($user->addresses()->count() == 0) {
            return __('api.address_not_found');
        }

        if ($totalPrice < $setting['min_order']) {
            return __('api.min_order', ['min_order' => $setting['min_order']]);
        }
        if ($totalPrice > $setting['max_order']) {
            return __('api.max_order', ['max_order' => $setting['max_order']]);
        }

        return true;
    }


    public function getAddressId($userId, $addressId)
    {
        if ($addressId) {
            return $addressId;
        }
        $user = User::find($userId);
        $address = $user->addresses()->where('is_main', 1)->first();
        return $address->id;
    }

    public function notificationAfterOrder($statusOrder = 'request')
    {
        $admins = User::where('type', 'admin')->where('notify', 1)->where('active', 1)->get();
        $notificationData = OrderNotificationData::getData($statusOrder);
        Notification::send($admins, $notificationData['title_ar'], $notificationData['title_en'], $notificationData['body_ar'], $notificationData['body_en']);
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
        $user = Auth::guard('api')->user();

        foreach ($user->devices as $device) {
            $this->firebaseNotification->sendNotificationWithDevice(
                $device,
                $notificationData['title_ar'],
                $notificationData['body_ar'],
                $dataFirebase,
            );
        }
    }






    public function getOrderShippingProducts($userId)
    {
        $user = User::find($userId);
        $cart = $user->cart;
        $totalShipping = 0;
        foreach ($cart->cartItems as $item) {
            $totalShipping += $item->product->shipping ?? 0;
        }
        return $totalShipping;
    }





    public function checkCoupon($code, $userId)
    {
        $user = User::find($userId);
        $coupon = Coupon::where('code', $code)->activeCoupons()->first();
        if (!$coupon) {
            return __('api.coupon_not_found');
        }
        if ($coupon->orders()->where('user_id', $user->id)->count() >= $coupon->user_limit) {
            return __('api.coupon_user_limit', ['user_limit' => $coupon->user_limit]);
        }
        $totalPriceAfterDiscountBeforeCoupon = $user->totalPriceInCart();

        if ($coupon->min_order >= $totalPriceAfterDiscountBeforeCoupon) {
            return __('api.coupon_min_order', ['min_order' => $coupon->min_order]);
        }
        return true;
    }

    public function getDataCouponInOrder(?string $code = null): array
    {
        if (empty($code)) {
            return [];
        }

        $coupon = Coupon::query()
            ->where('code', trim($code))
            ->activeCoupons()
            ->first();

        if (!$coupon) {
            return [];
        }

        return [
            'coupon_id'       => $coupon->id,
            'coupon_type'     => $coupon->type,
            'coupon_discount' => (float) $coupon->discount,
        ];
    }

    public function getOrderDiscountBeforeCoupon($userId)
    {
        $user = User::find($userId);
        $discount = 0;
        $discount = $user->totalPriceInCartBeforeDiscount() - $user->totalPriceInCart();

        return $discount;
    }

    // this method is used to calculate the discount after the coupon 
    // this method it take 4 parameters 
    // 1- the price after the discount before the coupon
    // 2- the type of the coupon
    // 3- the discount of the coupon

    public function getOrderDiscountAfterCoupon(float $priceBeforeCoupon, ?string $couponType = null, ?float $couponDiscount = null,): float
    {
        if (empty($couponType) || empty($couponDiscount)) {
            return 0;
        }
        $discount = 0;
        if ($couponType === 'percent') {
            $discount = ($priceBeforeCoupon * $couponDiscount) / 100;
        } elseif ($couponType === 'fixed') {
            $discount = $couponDiscount;
        }

        if ($discount > $priceBeforeCoupon) {
            $discount = $priceBeforeCoupon;
        }
        return round($discount);
    }


    public function getOrderDiscount($userId, $couponType = null, $couponDiscount = null)
    {
        $priceAfterDiscountBeforeCoupon = $this->getOrderDiscountBeforeCoupon($userId);
        return $priceAfterDiscountBeforeCoupon +
            $this->getOrderDiscountAfterCoupon($priceAfterDiscountBeforeCoupon, $couponType, $couponDiscount);
    }
}
