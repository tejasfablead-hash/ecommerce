<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function createRazorpayOrder(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = session('grandtotal') * 100; 

        $order = $api->order->create([
            'receipt' => 'order_' . $request->order_id,
            'amount' => $amount,
            'currency' => 'INR'
        ]);

        return response()->json([
            'razorpay_order_id' => $order['id'],
            'amount' => $amount
        ]);
    }

    public function razorpaySuccess(Request $request, SMSService $sms)
    {
        // Order update
        // dd($request->all());
         $order = Order::with('orderitem.product')
        ->where('id', $request->order_id)
        ->first();

          if (!$order) {
        return response()->json([
            'status' => false,
            'message' => 'Order not found'
        ], 404);
    }
      if ($order->payment_status === 'paid') {
        return response()->json([
            'status' => false,
            'message' => 'Order already paid'
        ], 400);
    }
       $order->update([
           'order_number' => $request->razorpay_order_id,
           'transactionId' => $request->razorpay_payment_id,
           'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'order_status' => 'confirmed'
        ]);

         foreach ($order->orderitem as $item) {

        $product = $item->product;

        if ($product->qty < $item->qty) {
            return response()->json([
                'status' => false,
                'message' => $product->name . ' is out of stock'
            ], 400);
        }

        $product->decrement('qty', $item->qty);

        if ($product->qty <= 0) {
            $product->update(['status' => 'inactive']);
        }
    }
     session()->forget([
        'subtotal',
        'gstvalue',
        'discountvalue',
        'discountprice',
        'grandtotal',
        'order_id'
    ]);

    Cart::where('user_id', $order->user_id)->delete();

       $phone = $order->phone;
    if (!str_starts_with($phone, '+')) {
        $phone = '+91' . $phone;
    }

    $sms->send(
        $phone,
        "✅ Payment Successful!
Order No: {$order->order_number}
Transaction No: {$order->transactionId}
Amount Paid: ₹{$order->grand_total}
Thank you for shopping with us."
    );

    session(['latest_paid_order_id' => $order->id]);

    return response()->json([
        'status' => true,
        'message' => 'Payment successful'
    ]);
    }
}
