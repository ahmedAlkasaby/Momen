<?php

namespace Database\Seeders;

use App\Enums\StatusOrderEnum;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\DeliveryTime;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\CartItemsService;
use App\Services\OrderService;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    protected $cartItemsService;
    protected $orderService;
    public function __construct(CartItemsService $cartItemsService, OrderService $orderService)
    {
        $this->cartItemsService = $cartItemsService;
        $this->orderService = $orderService;
    }
    public function run(): void
    {
        // إيقاف كل الأحداث أثناء التنفيذ
        \Illuminate\Database\Eloquent\Model::unsetEventDispatcher();

        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < rand(5, 10); $i++) {
                $orderId = $this->createOrder($user->id);
                for ($j = 0; $j < rand(1, 5); $j++) {
                    $this->createOrderItem($orderId, rand(1, 5));
                }
                if (rand(0, 1) == 1) {
                    $this->createCouponOrder($orderId);
                }
            }
        }

        // إعادة تشغيل الأحداث بعد الانتهاء (اختياري)
        \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
    }


    private function createOrder($userId)
    {
        $user = User::find($userId);
        $address = $user->addresses()->first();

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'payment_id' => Payment::first()->id,
            'city_id' => $address->city_id,
            'region_id' => $address->region_id,
            'price' => 0,
            'shipping' => $this->orderService->getShippingAddress($address->id, $user->id),
            'discount' => 0,
            'price_returned' => 0,
            'total' => 0,
            'status' => StatusOrderEnum::Request->value,
            'delivery_time_id' => DeliveryTime::first()->id,
        ]);
        return $order->id;
    }

    private function createOrderItem($orderId, $amount)
    {
        $order = Order::find($orderId);
        $randomProduct = Product::where('active', 1)->where('is_stock', 1)->inRandomOrder()->first();
        $data = $this->cartItemsService->getDataCartItem($randomProduct->id, $amount);
        $order->orderItems()->create($data);
        $order->update([
            'price' => $order->price + $data['total'],
            'shipping' => $order->shipping + $data['shipping'],
            'discount' => $order->discount + $data['total'] - $data['total_price'],
        ]);
        $order->update([
            'total' => $order->price + $order->shipping - $order->discount
        ]);
    }

    private function createCouponOrder($orderId)
    {
        $order = Order::find($orderId);
        $priceBeforeCoupon = $order->price - $order->discount;
        $coupon = Coupon::inRandomOrder()->first();
        if ($priceBeforeCoupon >= $coupon->min_order) {
            $order->update([
                'coupon_id' => $coupon->id,
                'coupon_type' => $coupon->type,
                'coupon_discount' => $coupon->discount,
                'discount' => $order->discount + $this->orderService->getOrderDiscountAfterCoupon($priceBeforeCoupon, $coupon->type, $coupon->discount),
            ]);
            $order->update([
                'total' => $order->price + $order->shipping - $order->discount
            ]);
        }
    }

    // craete orderItem -> [product,productChild,offerPrice,offerAmount,returned]

    // user -> order ,order return part ,order return all




}
