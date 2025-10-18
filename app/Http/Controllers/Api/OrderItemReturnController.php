<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderItemReturnRequest;
use App\Http\Resources\Api\OrderItemReturnCollection;
use App\Http\Resources\Api\OrderItemReturnResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemReturn;
use App\Services\OrderItemReturnService;
use Illuminate\Http\Request;

class OrderItemReturnController extends MainController
{
    protected $orderItemReturnService;
    public function __construct(OrderItemReturnService $orderItemReturnService)
    {
        $this->orderItemReturnService = $orderItemReturnService;
    }


    public function index(){
        $auth = Auth()->guard('api')->user();
        $orderItemReturns=$auth->orderItemReturns()->with('orderItem.product','orderItem.productChild')->paginate($this->perPage);
        return $this->sendDataCollection(new OrderItemReturnCollection ($orderItemReturns));
    }

    
    public function store(OrderItemReturnRequest $request)
    {
        $data = $request->validated();
        $auth = Auth()->guard('api')->user();
        $result=$this->orderItemReturnService->canReturnItem($auth->id,$data['order_item_id'],$data['amount']);
        if ($result !== true) {
           return  $this->messageError($result);
        }
        $orderItemReturn=OrderItemReturn::create($this->orderItemReturnService->getDataOrderItemReturn($data));
        return $this->sendData(new OrderItemReturnResource($orderItemReturn),__('api.order_item_returned'));

    }
}
