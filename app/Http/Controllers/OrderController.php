<?php

namespace App\Http\Controllers;

use App\Models\order as ModelsOrder;
use Illuminate\Http\Request;
use Stripe;
use Stripe\Customer;
use Stripe\Stripe as StripeStripe;
use Illuminate\Support\Facades\Validator;
use App\Models\package_users;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStripeCustomer (Request $request){

      $validator = Validator::make($request->all(), [
        'nameoncard' => 'required',
        'country' => 'required',
    ]);

    if($validator->fails()){
        //return $this->sendError('Validation Error.', $validator->errors());       
        return response()->json(['error' => $validator->errors()->all()], 200);
    }

      $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

      $pu = package_users::where('user_id','=',$request->user()->id)->first();

      if($pu == null){
        $customer =  $stripe->customers->create([
            'email' => $request->user()->email,
            'payment_method' => $request->paymentMethod,
            'name' => $request->nameoncard,
            'invoice_settings' => [
              'default_payment_method' => $request->paymentMethod
            ]
          ]);
        $response = $stripe->subscriptions->create([
            'customer' => $customer->id,
            'items' => [
              ['price' => $request->priceId],
            ],
        ]);
      }
      else {
        $response = $stripe->subscriptions->create([
          'customer' => $pu->customer_id,
          'items' => [
            ['price' => $request->priceId],
          ],
        ]);
      }

      $packages = ["ENTERPRISE" => 3, "BUSINESS" => 2, "PRO" => 1 ];

      $order = new ModelsOrder;

      $order->user_id = $request->user()->id;
      $order->name = $request->nameoncard;
      $order->country = $request->country;
      if(isset($request->street_address)){ $order->street = $request->street_address;}
      if(isset($request->city)){ $order->city = $request->city;}
      if(isset($request->zip)){ $order->zip = $request->zip;}
      if(isset($request->promocode)){ $order->promocode = $request->promocode;}
      $order->status = $response['status'];
      $order->paymentMethod = $request->paymentMethod;
      $order->priceId = $request->priceId;
      $order->package_id = $packages[$request->package];
      $order->packageType = $request->packageType;

      $order->save();

      if($response['status'] == "active"){
        if($pu == null) {
          $pu = new package_users;
          $pu->user_id = $request->user()->id;
          $pu->customer_id = $customer->id;
        }else if($pu->valid == 1){
          $stripe->subscriptions->cancel($pu->subscription_id);
        }

        $pu->valid = 1;
        $pu->usedTime = 0;
        $pu->usedAutom = 0;
        $pu->subscription_date = Carbon::now();
        $pu->subscription_id = $response->id;
        $pu->package_id = $packages[$request->package];

        $pu->save();
      }

      return response()->json($response,200);
    }
}
