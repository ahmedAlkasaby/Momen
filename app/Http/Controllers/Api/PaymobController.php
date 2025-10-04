<?php

namespace App\Http\Controllers\Api;


use App\Services\OrderService;
use App\Services\PaymentPaymobService;
use Illuminate\Http\Request;

class PaymobController extends MainController
{
    protected $paymob;
    public function __construct(PaymentPaymobService $paymob,OrderService $orderService)
    {
        $this->paymob = $paymob;
        $this->orderService=$orderService;
    }
    public function initiate()
    {
        if($this->orderService->canCreateOrder() !== true){
           return $this->messageError($this->orderService->canCreateOrder());
        }
        
        $totalPrice=$this->orderService->getTotalOrderPrice();
        $amountCents = $totalPrice * 100; // Convert to cents

        $billingData = $this->paymob->formatBillingData();

        $iframeUrl = $this->paymob->processPayment($amountCents, $billingData);

        return $this->sendData(['payment_url' => $iframeUrl], __('api.payment_initiated'));
    }

     public function callBack(Request $request)
    {
        $response = $this->paymob->callBack($request);
        if ($response) {

            return $this->messageSuccess(__('api.payment_success')); 
        }
        return $this->messageError(__('api.payment_failed'));
    }
}
