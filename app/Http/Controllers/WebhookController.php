<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function webhook() 
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_WEBHOOK_SECRET'));



// This is your Stripe CLI webhook secret for testing your endpoint locally.
$endpoint_secret = getenv('str');

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  return response('', 401);

} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  return response('', 402);
}

// Handle the event
switch ($event->type) {
  case 'payment_intent.succeeded':
    $paymentIntent = $event->data->object;
  // ... handle other event types
  default:
    echo 'Received unknown event type ' . $event->type;
}

return response('', 200);
    }
}
