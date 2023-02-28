<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CheckoutController extends Controller
{
  public function checkout(Request $request)
  {
    $user = $request->user();
    $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET'));
    list($products, $cartItems) = Cart::getProductsAndCartItems();
    $lineItems = array();
    $totalPrice = 0;

    foreach ($products as $product) {
      $quantity = $cartItems[$product->id]['quantity'];
      $totalPrice += $product->price * $quantity;
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
      'success_url' => route('checkout.success', [], true) . '?sessionId={CHECKOUT_SESSION_ID}',
      'cancel_url' => route('checkout.failure', [], true),
    ]);

    $orderData = array(
      'total_price' => $totalPrice,
      'status' => OrderStatus::Unpaid,
      'created_by' => $user->id,
      'updated_by' => $user->id,
    );
    $order = Order::create($orderData);


    $paymentData = array(
      'order_id' => $order->id,
      'amount' => $totalPrice,
      'type' => 'cc',
      'status' => PaymentStatus::Pending,
      'created_by' => $user->id,
      'updated_by' => $user->id,
      'session_id' => $checkout_session->id
    );

    Payment::create($paymentData);

    return response('', 409)
      ->header('X-Inertia-Location', $checkout_session->url);
    //   return redirect()->to($checkout_session->url);

  }
  public function success(Request $request)
  {
    $user = $request->user();
    $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET'));
    try {
      $sessionId = $request->get('sessionId');
      $session = $stripe->checkout->sessions->retrieve($sessionId);
      if (!$session) return Inertia::render('Failure', ['message' => 'Invalid session ID']);
      $payment = Payment::query()->where(['session_id' => $session->id, 'status' => PaymentStatus::Pending])->first();
      if(!$payment) return Inertia::render('Failure', ['message' => 'Payment Does not exist']);
      $payment->status = PaymentStatus::Paid;
      $payment->update();

      // dd($payment);
      $order  = $payment->order;


      $order->status = OrderStatus::Paid;
      $order->update();

      CartItem::where(['user_id' => $user->id])->delete();

      $customer = $stripe->customers->retrieve($session->customer);
      return Inertia::render('Success', [
        'customer' => $customer
      ]);
    } catch (\Exception $e) {
      return Inertia::render('Failure', ['message' => $e->getMessage()]);
    }
  }

  public function failure(Request $request)
  {

    return Inertia::render('Failure', []);
  }
}
