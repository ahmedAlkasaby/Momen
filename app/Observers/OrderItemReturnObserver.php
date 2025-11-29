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
        Log::info('Observer Triggered: updated()', [
            'order_item_return_id' => $orderItemReturn->id,
            'dirty' => $orderItemReturn->getDirty(),
            'new_status' => $orderItemReturn->status->value ?? null,
        ]);

        if ($orderItemReturn->isDirty('status')) {

            Log::info('Status changed', [
                'old' => $orderItemReturn->getOriginal('status'),
                'new' => $orderItemReturn->status->value,
            ]);

            // RETURNED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::RETURNED->value) {

                Log::info('Handling RETURNED state');

                $orderItemReturn->updateQuietly([
                    'returned_at' => now(),
                    'is_returned' => 1,
                ]);

                Log::info('OrderItemReturn updated (returned)');

                $order = Order::find($orderItemReturn->order_id);

                Log::info('Original order data', [
                    'order_id' => $order->id,
                    'price_returned_old' => $order->price_returned,
                    'total_old' => $order->total,
                ]);

                $order->update([
                    'price_returned' => $order->price_returned + $orderItemReturn->total_price_return,
                    'total' => $order->total - $orderItemReturn->total_price_return,
                    'status' => $this->getStatusOfOrder($orderItemReturn->order_id),
                ]);

                Log::info('Order updated after return', [
                    'price_returned_new' => $order->price_returned,
                    'total_new' => $order->total,
                    'status_new' => $order->status,
                ]);
            }

            // APPROVED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::APPROVED->value) {
                
                Log::info('Handling APPROVED state');

                $orderItemReturn->updateQuietly([
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                ]);

                Log::info('OrderItemReturn approved', [
                    'approved_by' => Auth::id(),
                ]);
            }

            // REJECTED
            if ($orderItemReturn->status->value == StatusOrderItemReturnEnum::REJECTED->value) {

                Log::info('Handling REJECTED state');

                $orderItemReturn->updateQuietly([
                    'rejected_at' => now(),
                    'rejected_by' => Auth::id(),
                ]);

                Log::info('OrderItemReturn rejected', [
                    'rejected_by' => Auth::id(),
                ]);
            }
        }
    }

    private function getStatusOfOrder($orderId)
    {
        Log::info('Calculating order status', ['order_id' => $orderId]);

        $order = Order::find($orderId);

        $countOrderItems = $order->orderItems->count();
        $countOrderItemReturned = $order->orderItemReturns->where('is_returned', 1)->count();

        Log::info('Order counts', [
            'items_total' => $countOrderItems,
            'items_returned' => $countOrderItemReturned,
        ]);

        if ($countOrderItems == $countOrderItemReturned) {
            Log::info('Order fully returned');
            return StatusOrderEnum::Returned->value;
        }

        if ($countOrderItems > $countOrderItemReturned) {
            Log::info('Order partially returned');
            return StatusOrderEnum::ReturnedPartial->value;
        }
    }
}
