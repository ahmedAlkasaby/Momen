<?php

namespace App\Observers;

use App\Enums\StatusOrderEnum;
use App\Enums\StatusOrderItemReturnEnum;
use App\Models\Order;
use App\Models\OrderItemReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderItemReturnObserver
{
    public function updated(OrderItemReturn $orderItemReturn)
    {
        if ($orderItemReturn->isDirty('status')) {

            // RETURNED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::RETURNED->value) {

                $orderItemReturn->updateQuietly([
                    'returned_at' => now(),
                    'is_returned' => 1,
                ]);


                $order = Order::find($orderItemReturn->order_id);

                $order->update([
                    'price_returned' => $order->price_returned + $orderItemReturn->total_price_return,
                    'total' => $order->total - $orderItemReturn->total_price_return,
                    'status' => $this->getStatusOfOrder($orderItemReturn->order_id),
                ]);
            }

            // APPROVED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::APPROVED->value) {
                
                $orderItemReturn->updateQuietly([
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                ]);

            }

            // REJECTED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::REJECTED->value) {


                $orderItemReturn->updateQuietly([
                    'rejected_at' => now(),
                    'rejected_by' => Auth::id(),
                ]);
            }
        }
    }

    private function getStatusOfOrder($orderId)
    {

        $order = Order::find($orderId);

        $countOrderItems = $order->orderItems->count();
        $countOrderItemReturned = $order->orderItemReturns->where('is_returned', 1)->count();


        if ($countOrderItems == $countOrderItemReturned) {
            return StatusOrderEnum::Returned->value;
        }

        if ($countOrderItems > $countOrderItemReturned) {
            return StatusOrderEnum::ReturnedPartial->value;
        }
    }
}
