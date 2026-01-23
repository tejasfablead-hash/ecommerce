<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{
    public function success(Request $request)
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

        $order->update([
            'order_number' => $request->paypal_order_id,
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

        return response()->json([
            'status' => true,
            'order_number' =>  $request->paypal_order_id,
            'message' => 'Thank you. Your order has been received'
        ]);
    }


    public function confirm()
    {
        $user = Auth::id();
        if ($user == true) {
            $order = Order::where('user_id', $user)
                ->where('payment_status', 'paid')
                ->latest()
                ->with(['orderitem.product'])
                ->first();
        }
        // dd($order);

        return view('Ecommerce.Pages.confirm', compact('order'));
    }
}
