<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function paypal_process(){
        $total=45;
        $carts_of_user=Cart::where('user_id',auth()->user()->id)->get();
        foreach ($carts_of_user as $cart) {
            $total+=($cart->qty*$cart->product->selling_price);
        }
        // $certificate_path = '"C:\cacert.pem"';
          // تعيين إعدادات cURL
        // $curl_options = array(
        //          CURLOPT_CAINFO => $certificate_path
        //         );

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();
        // dd(3);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal_sucess'),
                "cancel_url" => route('paypal_cancel'),
            ],
            "purchase_units" => [

                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $total
                    ]
            ]
        ]);
        dd($response);


        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
            ->route('cart.edit')
            ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('cart.edit')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    // public function paypal_process() {
    //     $total = 45;
    //     $carts_of_user = Cart::where('user_id', auth()->user()->id)->get();
    //     foreach ($carts_of_user as $cart) {
    //       $total += ($cart->qty * $cart->product->selling_price);
    //     }

    //     // ... (Rest of your code)

    //     $baseUrl = 'https://api-m.sandbox.paypal.com/v2/checkout/orders'; // PayPal Sandbox API endpoint

    //     // PayPal API credentials (replace with your actual credentials)
    //     $clientId = env('PAYPAL_SANDBOX_CLIENT_ID');
    //     $clientSecret = env('PAYPAL_SANDBOX_CLIENT_SECRET');

    //     $client = new \GuzzleHttp\Client([
    //       'auth' => [
    //         $clientId,
    //         $clientSecret,
    //         'basic',
    //       ]
    //     ]);

    //     $data = [
    //       "intent" => "CAPTURE",
    //       "application_context" => [
    //         "return_url" => route('paypal_sucess'),
    //         "cancel_url" => route('paypal_cancel'),
    //       ],
    //       "purchase_units" => [
    //         [
    //           "amount" => [
    //             "currency_code" => "USD",
    //             "value" => $total
    //           ]
    //         ]
    //       ]
    //     ];

    //     try {
    //       $response = $client->post($baseUrl, [
    //         'json' => $data
    //       ]);

    //       $responseData = json_decode($response->getBody(), true);

    //       // ... (Process the API response)

    //       if (isset($responseData['id']) && $responseData['id'] != null) {
    //         // Payment successful

    //         // Extract the approval URL
    //         foreach ($responseData['links'] as $links) {
    //           if ($links['rel'] == 'approve') {
    //             return redirect()->away($links['href']);
    //           }
    //         }

    //         // If no approval URL found, redirect to cart edit page with an error message
    //         return redirect()->route('cart.edit')->with('error', 'Unable to retrieve PayPal approval URL.');
    //       } else {
    //         // Payment failed

    //         // Extract the error message
    //         $errorMessage = $responseData['message'] ?? 'An error occurred while processing the payment.';

    //         // Redirect to cart edit page with the error message
    //         return redirect()->route('cart.edit')->with('error', $errorMessage);
    //       }
    //     } catch (\GuzzleHttp\Exception\ClientException $e) {
    //       $errorMessage = $e->getResponse()->getBody()->getContents();
    //       return redirect()->route('cart.edit')->with('error', 'Error: ' . $errorMessage);
    //     }
    // }


    public function paypal_sucess(){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('cart.edit')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('cart.edit')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paypal_cancel(){
        return redirect()
        ->route('cart.edit')
        ->with('error', $response['message'] ?? 'You have canceled the transaction.');
   }

}





