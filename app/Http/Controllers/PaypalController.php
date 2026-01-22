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
         $order = Order::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->with('orderitem.product')
            ->latest()
            ->first();
        // dd($order);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }


        Order::where('user_id', Auth::id())->update([
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

            $product->qty = $product->qty - $item->qty;
            $product->save();
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
