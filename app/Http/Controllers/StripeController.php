<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeController extends Controller
{
    public function createSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $order = Order::with('orderitem.product')->findOrFail($request->order_id);

        $productNames = $order->orderitem
            ->map(fn($item) => $item->product->name)
            ->implode(', ');

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
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['url' => $session->url]);
    }


    public function success(Request $request, SMSService $sms)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = StripeSession::retrieve($request->session_id);
        $orderId = $session->metadata->order_id;
        $order = Order::with('orderitem.product')->findOrFail($orderId);

        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'transactionId' => $session->payment_intent,
                'order_number' => $session->id,
                'order_status' => 'confirmed',
            ]);

            foreach ($order->orderitem as $item) {
                $product = $item->product;
                $product->decrement('qty', $item->qty);
                if ($product->qty <= 0) {
                    $product->update(['status' => 'inactive']);
                }
            }

            Cart::where('user_id', $order->user_id)->delete();
            session()->forget([
                'subtotal',
                'gstvalue',
                'discountvalue',
                'discountprice',
                'grandtotal',
                'order_id'
            ]);

            $phone = str_starts_with($order->phone, '+') ? $order->phone : '+91' . $order->phone;
            $sms->send(
                $phone,
                "✅ Payment Successful!
Order No: {$order->order_number}
Transaction No: {$order->transactionId}
Amount Paid: ₹{$order->grand_total}"
            );
            session(['latest_paid_order_id' => $order->id]);
        }

        return redirect()->route('UserCheckoutPage', ['stripe' => 'success']);
    }
}
