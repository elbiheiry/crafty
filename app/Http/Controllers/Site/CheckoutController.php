<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserSubscribtion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * return checkout page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('site')->user();
        $items = \Cart::getContent();

        return view('site.pages.checkout.index' ,compact('user' , 'items'));
    }

    /**
     * Complete checkout
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $country = "EG";
        
        $amount= [
            "total"=> \Cart::getTotal().'00',
            "currency"=> 'EGP',
        ];

        $order = Order::create([
            'user_id' => auth()->guard('site')->id(),
            'order_details' => json_encode(\Cart::getContent()),
            'status' => 'pending'
        ]);

        $reference = $order->id;
        
        $productList= [];
        foreach (\Cart::getContent() as $item) {
            array_push($productList , [
                "productId" => $item->attributes['id'],
                "name" => $item->name,
                "price" => $item->price,
                'description' => $item->associatedModel == 'course' ? 'course' : 'product',
                "quantity" => $item->quantity
            ]);
        }
        
        $returnUrl  = route('site.checkout.return');
        $callbackUrl  = route('site.checkout.success');
        $cancelUrl  = route('site.checkout.cancel');

        $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
        $response = $httpClient->request('POST', 'https://sandboxapi.opaycheckout.com/api/v1/international/cashier/create', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                        'Authorization' => 'Bearer OPAYPUB16450149351960.03643818418074518',
                        'MerchantId' => '281822021641960'
                    ],
                    'body' => json_encode( [
                                    'country' => $country,
                                    'reference' => $reference,
                                    'amount' => $amount,
                                    'productList' => $productList,
                                    'returnUrl' => $returnUrl,
                                    'callbackUrl'=> $callbackUrl,
                                    'cancelUrl' => $cancelUrl,
                                ] , true)
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        return response()->json($response['data']['cashierUrl'] , 200);
        
    }

    public function success(Request $request)
    {
        if($request->payload['status'] === 'SUCCESS'){
            $order = Order::where('id' , $request->payload['reference'])->first();
            $order->status = 'Done';
            $order->payment_details = $request->all();
            $order->save();
            
            if($order->user_subscribtion_id){
                $subscribtion = UserSubscribtion::where('id' , $order->user_subscribtion_id)->first();
                $subscribtion->status = 'Done';
                $subscribtion->save();
            }
        }else{
            $this->cancel($request);
        }
    }

    public function return_url()
    {
        \Cart::clear();
        return view('site.pages.checkout.success');
    }

    public function cancel()
    {
        return view('site.pages.checkout.cancel');
    }

    public function paymob()
    {
        $token = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRVeU1ERXhMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuQ0VJNzl4VGFsTHFGWW5xVzdrTnhHZHd4OS1tcGZOTDUwdm5JWUlMVzdCTWhSWlcxcmttcnRMc3I5UHhlbTNLZEt6Y1Z4V0tUMGxTNG1vU3dhbGZQNEE=";
        $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
        $response = $httpClient->request('POST', 'https://accept.paymob.com/api/auth/tokens', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json'
                    ],
                    'body' => json_encode( [
                                'api_key' => $token
                            ] , true)
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        $amount_cents= \Cart::getTotal() * 100;

        $currency = 'EGP';
        $token = $response['token'];

        $order = Order::create([
            'user_id' => auth()->guard('site')->id(),
            'order_details' => json_encode(\Cart::getContent()),
            'status' => 'pending'
        ]);
        $merchant_order_id = $order->id;
        $delivery_needed = "false";

        $productList= [];
        foreach (\Cart::getContent() as $item) {
            array_push($productList , [
                "name" => $item->name,
                "amount_cents" => $item->price * 100,
                'description' => $item->associatedModel == 'course' ? 'course' : 'product',
                "quantity" => $item->quantity
            ]);
        }
        
        $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
        $response = $httpClient->request('POST', 'https://accept.paymob.com/api/ecommerce/orders', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json'
                    ],
                    'body' => json_encode( [
                                    'auth_token' => $token,
                                    'delivery_needed' => $delivery_needed,
                                    'currency' => $currency,
                                    'merchant_order_id' => $merchant_order_id,
                                    'amount_cents' => $amount_cents,
                                    'items' => $productList
                                ] , true)
        ]);
        
        $response = json_decode($response->getBody()->getContents(), true);
        $response['auth_token'] = $token;

        $amount_cents= $response['amount_cents'];
        $token = $response['auth_token'];
        $names = explode(" " , auth()->guard('site')->user()->name);

        $httpClient = new \GuzzleHttp\Client();
        $response1 = $httpClient->request('POST', 'https://accept.paymob.com/api/acceptance/payment_keys', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json'
                    ],
                    'body' => json_encode( [
                                    'auth_token' => $token,
                                    'currency' => 'EGP',
                                    'order_id' => $response['id'],
                                    'amount_cents' => $amount_cents,
                                    'expiration' => 3600,
                                    'billing_data' => [
                                        "apartment" => "NA", 
                                        "email" => auth()->guard('site')->user()->email, 
                                        "floor" =>  "NA", 
                                        "first_name" => $names[0], 
                                        "street" =>  "NA", 
                                        "building"=> "NA", 
                                        "phone_number" => auth()->guard('site')->user()->phone ? auth()->guard('site')->user()->phone : 'NA',
                                        "shipping_method" => "NA", 
                                        "postal_code" => "NA", 
                                        "city" => auth()->guard('site')->user()->city ? auth()->guard('site')->user()->city : 'NA', 
                                        "country" => auth()->guard('site')->user()->country ? auth()->guard('site')->user()->country : 'NA', 
                                        "last_name" => end($names) ? end($names) : $names[0], 
                                        "state" =>  auth()->guard('site')->user()->address ? auth()->guard('site')->user()->address : 'NA',
                                    ],
                                    'integration_id' => 1757249
                                ] , true)
        ]);
        $response1 = json_decode($response1->getBody()->getContents(), true);

        return response()->json($response1['token'] , 200);
    }

    public function paymob_success(Request $request)
    {
        if($request['success'] === "true"){
            $order = Order::where('id' , $request['merchant_order_id'])->first();
            $order->status = 'Done';
            $order->payment_details = $request->all();
            $order->save();
            
            \Cart::clear();
            return view('site.pages.checkout.success');
        }else{
            return redirect()->route('site.checkout.cancel');
        }
    }
}
