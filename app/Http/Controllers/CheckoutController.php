<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function success(Request $request) {
      $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET'));
      $session = $stripe->checkout->sessions->retrieve($request->get('sessionId'));
      // $session->customer_creation = 'always';
      $customer = $stripe->customers->retrieve($session->customer);
      dd($session, $customer);
    } 

    public function failure(Request $request) {
        dd($request->all());
    }
    public function checkout(Request $request) {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET'));


        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $lineItems = array();

        foreach($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                      'name' => $product->title,
                      'images' => [$product->image]
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $cartItems[$product->id]['quantity'],
                ];
        }

        $checkout_session = $stripe->checkout->sessions->create([
          'line_items' => $lineItems,
          'mode' => 'payment',
          'customer_creation' => 'always',
          'success_url' => route('checkout.success', [], true). '?sessionId={CHECKOUT_SESSION_ID}',
          'cancel_url' => route('checkout.failure', [], true),
        ]);
        
        
       

        return response('', 409)
            ->header('X-Inertia-Location', $checkout_session->url);
    //   return redirect()->to($checkout_session->url);
       
    }
}
