<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function createSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $order = Order::with('orderitem.product')
            ->where('id', $request->order_id)
            ->where('payment_status', 'pending')
            ->firstOrFail();
        $productNames = $order->orderitem->map(fn($item) => $item->product->name)->implode(', ');
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $productNames ?: 'Order Payment',
                    ],
                    'unit_amount' => (int) ($order->grand_total * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
            ],
       'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('stripe.cancel'),
        ]);

        return response()->json([
            'status' => true,
            'checkout_url' => $session->url
        ]);
    }


public function success(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $sessionId = $request->session_id;

    if (!$sessionId) {
        return redirect()->route('UserCheckoutPage')->with('error', 'Invalid payment session');
    }

    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    $orderId = $session->metadata->order_id ?? null;

    $order = Order::with('orderitem.product')->find($orderId);

    if ($order && $order->payment_status !== 'paid') {

        DB::transaction(function () use ($order, $session) {

            $order->update([
                'order_number' => $session->id,
                'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'transactionId'  => $session->payment_intent,
                'order_status'   => 'confirmed',
            ]);

            foreach ($order->orderitem as $item) {
                if ($item->product) {
                    $item->product->decrement('qty', $item->qty);

                    if ($item->product->qty <= 0) {
                        $item->product->update(['status' => 'inactive']);
                    }
                }
            }

            Cart::where('user_id', $order->user_id)->delete();
        });
    }

    return redirect()->route('UserConfirmPage')
        ->with('success', 'Payment successful!');
}


    public function cancel()
    {
        return redirect()->route('UserCheckoutPage', [
            'stripe' => 'cancel'
        ]);
    }

    // public function handle(Request $request)
    // {
    //     $payload = $request->getContent();
    //     $signature = $request->header('Stripe-Signature');
    //     $secret = config('services.stripe.webhook_secret');

    //     try {
    //         $event = Webhook::constructEvent($payload, $signature, $secret);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Invalid signature'], 400);
    //     }

    //     if ($event->type === 'checkout.session.completed') {

    //         $session = $event->data->object;
    //         $orderId = $session->metadata->order_id ?? null;

    //         $order = Order::with('orderitem.product')->find($orderId);

    //         if ($order && $order->payment_status !== 'paid') {

    //             DB::transaction(function () use ($order, $session) {

    //                 $order->update([
    //                     'order_number' => $session->id,
    //                     'payment_status' => 'paid',
    //                     'payment_method' => 'stripe',
    //                     'transactionId'  => $session->payment_intent,
    //                     'order_status'   => 'confirmed',
    //                 ]);

    //                 foreach ($order->orderitem as $item) {
    //                     if ($item->product) {
    //                         $item->product->decrement('qty', $item->qty);

    //                         if ($item->product->qty <= 0) {
    //                             $item->product->update(['status' => 'inactive']);
    //                         }
    //                     }
    //                 }

    //                 Cart::where('user_id', $order->user_id)->delete();
                    
    //             });

    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }
}
