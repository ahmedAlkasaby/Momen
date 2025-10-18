<?php

namespace App\Services;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\OrderNotificationData;
use App\Facades\SettingFacade as AppSettings;


class OrderService
{

    protected $firebaseNotification;

    public function __construct(FirebaseNotificationService $firebaseNotification)
    {
        $this->firebaseNotification = $firebaseNotification;
    }

    public function getShippingAddress($addressId,$userId)
    {
        $user = User::find($userId);
        $address = $user->addresses()->where('id', $addressId)->first();
        $shipping = $address->city->shipping;
        if ($address->region_id) {
            $shipping += $address->region->shipping;
        }
        return $shipping;
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

        if ($coupon->min_order > $totalPriceAfterDiscountBeforeCoupon) {
            return __('api.coupon_min_order', ['min_order' => $coupon->min_order]);
        }
        return true;
    }

    public function getDataCouponInOrder(?string $code = null): array
    {
        if (empty($code)) {
            return [
                'coupon_id'       => null,
                'coupon_type'     => null,
                'coupon_discount' => null,
            ];
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


    public function getCityId($addressId)
    {
        $address = Address::find($addressId);
        return $address->city_id;
    }
    public function getRegionId($addressId)
    {
        $address = Address::find($addressId);
        return $address->region_id;
    }
}
