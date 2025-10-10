<?php

namespace App\Observers;

use App\Enums\StatusOrderEnum;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\StatusTrackingOrder;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    protected function getAuthUserData()
    {
        foreach (['api', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return [
                    'id'   => Auth::guard($guard)->id(),
                    'type' => $guard
                ];
            }
        }
        return ['id' => null, 'type' => null];
    }

    public function created(Order $order)
    {
        $auth = $this->getAuthUserData();

        OrderStatus::create([
            'order_id'  => $order->id,
            'status'    => $order->status,
            'user_id'   => $auth['id'],
            'type_user' => $auth['type'],
        ]);

        if ($order->coupon_id != null) {
            $coupon = Coupon::find($order->coupon_id);
            $coupon->update([
                'use_count'=>($coupon->use_count + 1),
            ]);

        }
    }

    public function updated(Order $order)
    {
        if ($order->isDirty('status')) {
            $auth = $this->getAuthUserData();

            OrderStatus::create([
                'order_id'  => $order->id,
                'status'    => $order->status,
                'user_id'   => $auth['id'],
                'type_user' => $auth['type'],
            ]);
            if($order->status == StatusOrderEnum::Canceled->value){
                $order->update([
                    'cancel_by' => $auth['id'],
                    'cancel_date' => now(),   
                ]);
            }

            if ($order->status == StatusOrderEnum::Delivered->value) {
                $order->update([
                    'is_paid'=>1,
                    'total_paid'=>$order->total,
                    'remaining'=>0,
                ]);
            }   
        }
    }
}
