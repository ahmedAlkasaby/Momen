<?php

namespace Database\Seeders;

use App\Enums\StatusOrderEnum;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // تحميل البيانات مرة واحدة لتقليل استعلامات قاعدة البيانات
        $users = User::with(['addresses.city', 'addresses.region', 'cartItems.product'])
            ->where('type', 'client')
            ->get();

        $products = Product::all()->keyBy('id');
        $productIds = $products->keys()->toArray();

        $paymentIds = Payment::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            // اختيار مستخدم عشوائي
            $user = $users->random();

            $usedCombinations = [];

            for ($j = 0; $j < 3; $j++) {
                $productId = $faker->randomElement($productIds);

                // منع التكرار لنفس المستخدم ونفس المنتج
                if (isset($usedCombinations[$user->id][$productId])) {
                    continue;
                }

                CartItem::updateOrCreate(
                    ['user_id' => $user->id, 'product_id' => $productId],
                    ['amount' => rand(1, 3)]
                );

                $usedCombinations[$user->id][$productId] = true;
            }

            // تحديث cartItems في حالة حصل تغييرات
            $user->load('cartItems.product', 'addresses.city', 'addresses.region');

            // إنشاء الطلب
            $order = $user->orders()->create([
                'status'              => $faker->randomElement(StatusOrderEnum::cases()),
                'payment_id'          => $faker->randomElement($paymentIds),
                'shipping_address'    => $this->getShippingAddress($user),
                'notes'               => $faker->optional()->sentence(),
                'created_at'          => $faker->dateTimeBetween('-2 months', 'now'),
                'address_id'          => $user->addresses()->first()?->id,
                'shipping_products'   => $this->getOrderShippingProducts($user),
                'price'               => $this->getOrderPrice($user),
                'discount'            => $this->getOrderDiscount($user),
            ]);

            foreach ($user->cartItems as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'amount'        => $item->amount,
                    'price'         => $item->product->price,
                    'discount'      => $this->getDiscount($item->product_id),
                    'shipping_cost' => $item->product->shipping_cost ?? 0,
                ]);
            }

            // حذف cart items بعد ما اتعمل منها Order
            $user->cartItems()->delete();
        }
    }

    public function getOrderShippingProducts(User $user): float
    {
        return $user->cartItems->sum(fn($item) => $item->product->shipping_cost);
    }

    public function getOrderPrice(User $user): float
    {
        return $user->totalPriceInCart(); // يفترض إنها دالة جاهزة
    }

    public function getOrderDiscount(User $user): float
    {
        return $user->cartItems->sum(fn($item) => $this->getDiscount($item->product_id));
    }

    public function getShippingAddress(User $user): float
    {
        $address = $user->addresses()->where('active', 1)->first();
        if (! $address) return 0;

        $shipping = $address->city->shipping ?? 0;
        if ($address->region_id) {
            $shipping += $address->region->shipping ?? 0;
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
}
