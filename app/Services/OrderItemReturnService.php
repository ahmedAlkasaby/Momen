<?php

namespace App\Services;

use App\Enums\StatusOrderEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderItemReturnService
{

    protected $imageService;

    public function __construct(ImageHandlerService $imageService)
    {
        $this->imageService = $imageService;
    }

    
    public function canReturnItem($userId, $orderItemId, $amount)
    {
        $user = User::find($userId);
        $orderItem = OrderItem::find($orderItemId);
        $order = $orderItem->order->where('user_id', $user->id)->first();

        if (!$order) {
            return __('api.order_item_not_found_in_your_order');
        }
        if ($order->status != StatusOrderEnum::Delivered->value) {
            return __('api.order_not_deliveried');
        }
        if ($orderItem->is_return != 1) {
            return __('api.order_item_not_returnable');
        }
        if ($orderItem->return_at < now()) {
            return __('api.order_item_return_expired', ['return_at' => $orderItem->return_at]);
        }
        if ($amount > $orderItem->total_amount) {
            return __('api.cant_amount_returned_bigger_than_total_amount', ['total_amount' => $orderItem->total_amount]);
        }
        if ($amount < $orderItem->free_amount) {
            return __('api.order_item_return_amount_bigger_than_amount_free', ['amount_free' => $orderItem->free_amount]);
        }
        return true;
    }

    public function getOrderPriceBeforeDiscountCouponBeforeShipping($orderId)
    {
        $order = Order::find($orderId);
        $orderItems = $order->orderItems;
        $price = 0;
        foreach ($orderItems as $orderItem) {
            $price += $orderItem->price * $orderItem->amount;
        }
        return $price;
    }


    public function getDataOrderItemReturn($dataValidated)
    {
        $data = $dataValidated;
        $orderItem = OrderItem::find($data['order_item_id']);
        $order = $orderItem->order;
        $orderPrice = $this->getOrderPriceBeforeDiscountCouponBeforeShipping($order->id);
        $data['user_id'] = $order->user_id;
        $data['order_id'] = $order->id;
        $data['coupon_id'] = $order->coupon_id;
        $data['coupon_type'] = $order->coupon_type;
        $data['coupon_discount'] = $order->coupon_discount;
        $data['free_amount'] = $orderItem->free_amount;
        $data['offer_amount'] = $orderItem->offer_amount;
        $data['offer_amount_add'] = $orderItem->offer_amount_add;
        $data['actual_amount'] = $data['amount'] - $orderItem->free_amount;

        $data['price'] = $orderItem->price;
        $data['offer_price'] = $orderItem->offer_price;
        $data['price_return'] = $this->getPriceReturn(
            $data['coupon_type'],
            $data['coupon_discount'],
            $data['price'],
            $orderPrice
        );
        $data['total_price_return'] = $data['price_return'] * $data['actual_amount'];
        $data['coupon_discount_return'] = $data['actual_amount'] *($data['price'] - $data['price_return']);
        $data['image']=$this->imageService->uploadImage($data['image'],'order_item_return');
        return $data;
    }

    public function getPriceReturn($couponType, $couponDiscount, $price, $orderPrice)
    {
        $basePrice = $price;

        if (!$couponType || !$couponDiscount) {
            return $basePrice;
        }

        switch ($couponType) {
            case 'percent':
                $discount = ($basePrice * $couponDiscount) / 100;
                return $basePrice - $discount;

            case 'fixed':
                $orderTotal =  $orderPrice;
                $discountPerUnit = $couponDiscount / $orderTotal * $basePrice;
                return $basePrice - $discountPerUnit;

            default:
                return $basePrice;
        }
    }
}
