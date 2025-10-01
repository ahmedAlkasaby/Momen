<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaymentPaymobService
{
    protected $apiKey;
    protected $integrationId;
    protected $iframeId;

    public function __construct()
    {
        $this->apiKey = env('PAYMOB_API_KEY');
        $this->integrationId = env('PAYMOB_INTEGRATION_ID');
        $this->iframeId = env('PAYMOB_IFRAME_ID');
    }

    // 1) Get Auth Token
    public function getAuthToken()
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $this->apiKey
        ]);

        return $response['token'];
    }

    // 2) Create Order
    public function createOrder($authToken, $amountCents)
    {
        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token' => $authToken,
            'delivery_needed' => false,
            'amount_cents' => $amountCents,
            'currency' => "EGP",
            'items' => []
        ]);

        return $response->json();
    }

    public function getPaymentKey($authToken, $orderId, $amountCents, $billingData)
    {
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token' => $authToken,
            'amount_cents' => $amountCents,
            'expiration' => 3600,
            'order_id' => $orderId,
            'billing_data' => $billingData,
            'currency' => "EGP",
            'integration_id' => $this->integrationId,
        ]);

        return $response->json();
    }

    public function getIframeUrl($paymentToken)
    {
        return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
    }

    public function processPayment($amountCents, $billingData)
    {
        $authToken = $this->getAuthToken();
        $order = $this->createOrder($authToken, $amountCents);
        $paymentKey = $this->getPaymentKey($authToken, $order['id'], $amountCents, $billingData);
        return $this->getIframeUrl($paymentKey['token']);
    }


    public function formatBillingData()
    {
        $auth = Auth::guard('api')->user();
        $address = $auth->addresses()->where('active', 1)->first();
    
        return [
            "apartment"       => $address->apartment ?? "NA",
            "email"           => $auth->email ?? "NA",
            "floor"           => $address->floor ?? "NA",
            "first_name"      => $auth->first_name ?? "NA",
            "street"          => $address->street ?? "NA",
            "building"        => $address->building ?? "NA",
            "phone_number"    => $auth->phone ?? "NA",
            "shipping_method" => "PKG",
            "postal_code"     => $address->postal_code ?? "NA",
            "city"            => $address?->city?->nameLang('en') ?? "NA",
            "country"         => "EG",
            "last_name"       => $auth->last_name ?? "NA",
            "state"           => $address?->region?->nameLang('en') ?? "NA"
        ];
    }

    public function callBack(Request $request): bool
    {
        $response = $request->all();
        Storage::put('paymob_callback.json', json_encode($request->all()));
        if (isset($response['success']) && $response['success'] === 'true') {
            return true;
        }
        return false;
    }



    
}
