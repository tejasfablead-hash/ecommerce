<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{
    public function success(Request $request, SMSService $sms)
    {
        // dd($request->all());
        $orderId = session('order_id');

        $order = Order::with('orderitem.product')->find($orderId);
        // dd($order);

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
            'order_number' => $request->paypal_order_id,
            'transactionId' => $request->transaction_id,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'order_status' => 'confirmed'
        ]);
        session(['latest_paid_order_id' => $order->id]);

        foreach ($order->orderitem as $item) {

            $product = $item->product;

            if ($product->qty < $item->qty) {
                return response()->json([
                    'status' => false,
                    'message' => $product->name . ' is out of stock'
                ], 400);
            }

            $product->decrement('qty', $item->qty);
            $product->refresh();

            if ($product->qty - $item->qty <= 0) {
                $product->update([
                    'status' => 'inactive'
                ]);
            }
        }

        Cart::where('user_id', Auth::id())->delete();

        session()->forget([
            'subtotal',
            'gstvalue',
            'discountvalue',
            'discountprice',
            'grandtotal',
            'order_id'
        ]);
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


        return response()->json([
            'status' => true,
            'order_number' =>  $request->paypal_order_id,
            'message' => 'Thank you. Your order has been received'
        ]);
    }


    public function confirm()
    {
        $userId = Auth::id();
        $order = null;
        if ($userId) {
            $order = Order::with('orderitem.product')
                ->where('user_id', $userId)
                ->where('payment_status', 'paid')
                ->latest()
                ->first();
        }
        // dd($order);

        return view('Ecommerce.Pages.confirm', compact('order'));
    }

    public function confirmview($id)
    {
        $userId = Auth::id();

        $order = Order::with('orderitem.product')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->where('payment_status', 'paid')
            ->latest()
            ->first();
            return view('Ecommerce.Pages.confirm', compact('order'));
    }
}
