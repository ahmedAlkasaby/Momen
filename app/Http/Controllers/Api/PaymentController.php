<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PaymentCollection;
use App\Http\Resources\Api\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends MainController
{
    public function index(){
        $payments=Payment::active()->paginate($this->perPage);
        return $this->sendData(new PaymentCollection($payments));
    }

    public function show(string $id){
        $payment=Payment::active()->where('id',$id)->first();
        if(! $payment){
            return $this->messageError(__('api.payment_not_found'));
        }
        return $this->sendData(new PaymentResource($payment));

    }
}
