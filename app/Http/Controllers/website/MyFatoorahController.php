<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FatoorahServices;
use App\Models\Cart;
class MyFatoorahController extends Controller
{
    private $fatoorahServices;
    public function __construct(FatoorahServices $fatoorahServices){
        $this->fatoorahServices=$fatoorahServices;
    }
    public function checkout(Request $request)
    {

        $total=45;
        $carts_of_user=Cart::where('user_id',auth()->user()->id)->get();
        foreach ($carts_of_user as $cart) {
            $total+=($cart->qty*$cart->product->selling_price);
        }

        // $fatoorahServices = new FatoorahServices;
        $curl = curl_init();

        // $payment = new OrderPayment();
        curl_setopt($curl, CURLOPT_CAINFO, "C:\cert.wmtransfer.com_WebMoney Transfer Root CA.crt");


        $data = [
            "CustomerName" => 'customer_name',
             "Notificationoption"=> "LNK",
            "Invoicevalue" =>$total,// total_price
            "CustomerEmail" =>auth()->user()->email,
            "CalLBackUrl"=>route('callback'),
            "Errorurl"=> route('error'),
            "Languagn"=> 'en',
            "DisplayCurrencyIna"=>'SAR'
        ];


        $response = $this->fatoorahServices->sendPayment($data);
        return $response;

        if(isset($response['IsSuccess']))
        if($response['IsSuccess']==true){

            $InvoiceId  = $response['Data']['InvoiceId']  ; // save this id with your order table
            $InvoiceURL = $response['Data']['InvoiceURL'] ;

        }
            return redirect($response['Data']['InvoiceURL']);// redirect for this link to view payment page
     }




    public function callback(Request $request)
    {
        $apiKey = 'your_token';
        $postFields = [
            'Key'     => $request->paymentId,
            'KeyType' => 'paymentId'
            ];
            $response = $fatoorahServices->callAPI("https://apitest.myfatoorah.com/v2/getPaymentStatus", $apiKey, $postFields);
            $response = json_decode($response);
            if(!isset($response->Data->InvoiceId))
                return response()->json(["error" => 'error','status' =>false],404);
                $InvoiceId =  $response->Data->InvoiceId  ;// get your order by payment_id
                if($response->IsSuccess==true){
                    if($response->Data->InvoiceStatus=="Paid")//||$response->Data->InvoiceStatus=='Pending'
                    if( $your_order_total_price==$response->Data->InvoiceValue){

                    /**
                     *
                     * The payment has been completed successfully. You can change the status of the order
                     *
                     */

                    }
                }

                return response()->json(["error" => 'error','status' =>false],404);
    }

    public function error(){
        return 'error';

    }

}
