<?php

namespace App\Http\Controllers\Api;

use App\Helpers\OrderNotificationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Http\Resources\Api\OrderCollection;
use App\Http\Resources\Api\OrderResource;
use App\Models\Notification;
use App\Models\User;
use App\Services\FirebaseNotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends MainController
{
    protected $orderService;

    public function __construct(OrderService $orderService){
        $this->orderService=$orderService;
    }

    public function index()
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $data=['user','address','delivery','payment','deliveryTime','orderItems.product'];
        $orders=$user->orders()->with($data)->paginate($this->perPage);
        return $this->sendData(new OrderCollection($orders));
    }

    public function store(OrderRequest $request)
    {
       $data = $request->validated();

       $auth=Auth()->guard('api')->user();
       $user=User::find($auth->id);

       if($this->orderService->canCreateOrder() !== true){
           return $this->messageError($this->orderService->canCreateOrder());
       }

        DB::transaction(function () use ($user, $data) {
            $data['shipping_address'] = $this->orderService->getShippingAddress();
            $data['address_id'] = $this->orderService->getAddressId();
            $data['price'] = $this->orderService->getOrderPrice();
            $data['dicount'] = $this->orderService->getOrderDiscount();
            $data['shipping_products'] = $this->orderService->getOrderShippingProducts();
            $order = $user->orders()->create($data);
            $items = $user->cartItems()->with('product')->get();
            $this->orderService->createOrderItems($items, $order);
            $user->cartItems()->delete();
            $this->orderService->notificationAfterOrder();
        });

       return $this->messageSuccess(__('api.order_added'));


    }


    public function show(string $id)
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $data=['user','address','delivery','payment','deliveryTime','orderItems.product'];

        $order=$user->orders()->with($data)->where('id',$id)->first();
        if (!$order) {
            return $this->messageError(__('api.order_not_found'));
        }
        return $this->sendData(new OrderResource($order));
    }

    public function update(UpdateOrderRequest $request,string $id)
    {
        $data = $request->validated();
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        $order=$user->orders()->where('id',$id)->first();
        if (!$order) {
            return $this->messageError(__('api.order_not_found'));
        }
        DB::transaction(function () use ($order, $data) {
            $order->update($data);
            $this->orderService->notificationAfterOrder($order->status->value);
        });

        return $this->messageSuccess(__('api.order_updated'));
    }




}
