<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DeliveryTimeCollection;
use App\Http\Resources\Api\DeliveryTimeResource;
use App\Http\Resources\Api\MainCollection;
use App\Models\DeliveryTime;
use Illuminate\Http\Request;

class DeliveryTimeController extends MainController
{
    public function index(){
        $deliveryTimes=DeliveryTime::active()->paginate($this->perPage);
        return $this->sendDataCollection(new MainCollection($deliveryTimes,'delivery_times'));
    }

    public function show(string $id){
        $deliveryTime=DeliveryTime::active()->where('id',$id)->first();
        if (!$deliveryTime) {
            return $this->messageError(__('api.delivery_time_not_found'));
        }
        return $this->sendData(new DeliveryTimeResource($deliveryTime));


    }
}
