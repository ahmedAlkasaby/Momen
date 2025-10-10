<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusOrderEnum;
use App\Helpers\OrderHelper;
use App\Helpers\OrderNotificationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Http\Resources\Api\OrderCollection;
use App\Http\Resources\Api\OrderResource;
use App\Jobs\SendOrderNotificationJob;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Services\FirebaseNotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends MainController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $auth = Auth()->guard('api')->user();
        $user = User::find($auth->id);
        $data = OrderHelper::getOrderRelations();
        $orders = $user->orders()->with($data)->paginate($this->perPage);
        return $this->sendData(new OrderCollection($orders));
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();

        $user = Auth()->guard('api')->user();
        
        if ($this->orderService->canCreateOrder($user->id) !== true) {
            return $this->messageError($this->orderService->canCreateOrder($user->id));
        }
        if (isset($data['coupon_code']) && $data['coupon_code'] != null) {
            if ($this->orderService->checkCoupon($data['coupon_code'], $user->id) !== true) {
                return $this->messageError($this->orderService->checkCoupon($data['coupon_code'], $user->id));
            }
        }
        DB::transaction(function () use ($user, $data) {
            $data['address_id'] = $this->orderService->getAddressId($user->id, $data['address_id'] ?? null);
            $data['city_id'] = $this->orderService->getCityId($data['address_id']);
            $data['region_id'] = $this->orderService->getRegionId($data['address_id']);
            $data['price'] = $user->totalPriceInCartBeforeDiscount();
            $data['shipping_address'] = $this->orderService->getShippingAddress($data['address_id']);
            $data['shipping_products'] = $this->orderService->getOrderShippingProducts($user->id);
            $data['shipping'] = $data['shipping_address'] + $data['shipping_products'];
            $couponData = $this->orderService->getDataCouponInOrder($data['coupon_code'] ?? null);
            if (!empty($couponData)) {
                $data = array_merge($data, $couponData);
            }
            $data['discount']=$this->orderService->getOrderDiscount($user->id,$data['coupon_type'],$data['coupon_discount']);
            $data['total'] = $data['price'] + $data['shipping'] - $data['discount'];
            $order = $user->orders()->create($data);
            $items = $user->cart->cartItems()->get();
            $order->orderItems()->createMany($items->toArray());
            $user->cart->delete();
            SendOrderNotificationJob::dispatch($user->id,StatusOrderEnum::Request->value);

        });

        return $this->messageSuccess(__('api.order_added'));
    }


    public function show(string $id)
    {
        $auth = Auth()->guard('api')->user();
        $user = User::find($auth->id);
        $data = OrderHelper::getOrderRelations();
        $order = $user->orders()->with($data)->where('id', $id)->first();
        if (!$order) {
            return $this->messageError(__('api.order_not_found'));
        }
        return $this->sendData(new OrderResource($order));
    }

    public function update(UpdateOrderRequest $request, string $id)
    {
        $data = $request->validated();
        $auth = Auth()->guard('api')->user();
        $user = User::find($auth->id);
        $order = $user->orders()->where('id', $id)->first();
        if (!$order) {
            return $this->messageError(__('api.order_not_found'));
        }
        DB::transaction(function () use ($order, $data,$user) {
            $order->update($data);
            SendOrderNotificationJob::dispatch($user->id,$order->status);

        });

        return $this->messageSuccess(__('api.order_updated'));
    }
}
