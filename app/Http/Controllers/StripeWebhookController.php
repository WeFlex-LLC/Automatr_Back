<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\package_users;

class StripeWebhookController extends Controller
{
    public function handle(Request $request){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret =  env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
        } catch(\UnexpectedValueException $e) {
        // Invalid payload
        http_response_code(400);
        exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        http_response_code(400);
        exit();
        }
        // Handle the event
        switch ($event->type) {
        case 'invoice.payment_succeeded':
            if($event->data->object->subscription != null)
                $this->setValid($event->data->object->subscription);
            break;
        case 'invoice.payment_failed':
            if($event->data->object->subscription != null)
                $this->setNotValid($event->data->object->subscription);
            break;
        case 'customer.subscription.deleted':
            $this->setNotValid($event->data->object->id);
            break;
        case 'customer.subscription.paused':
            $this->setNotValid($event->data->object->id);
            break;
        case 'customer.subscription.pending_update_expired':
            $this->setNotValid($event->data->object->id);
            break;
        default:
            echo 'Received unknown event type ' . $event->type;
        }
        http_response_code(200);
    }

    private function setNotValid($sub_id){
        $pu = package_users::where('subscription_id','=',$sub_id)->first();

        if($pu){
            $pu->valid = 0;

            $pu->save();
        }
    }

    private function setValid($sub_id){
        $pu = package_users::where('subscription_id','=',$sub_id)->first();

        if($pu){
            $pu->valid = 1;

            $pu->save();
        }
    }
}
