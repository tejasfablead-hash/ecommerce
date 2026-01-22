<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // dd($request->all());
        $user = Auth::id();
        $cartItems = Cart::where('user_id', $user)->with('getproduct')->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
            return redirect()->route('UserProductPage')
                ->with('error', 'Your cart is empty');
        }

        $validate = Validator::make($request->all(), [
            'userid' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'postcode' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => '*Please fill Billing Details'
            ], 422);
        }
        $order = Order::create([
            'user_id'           => $user,
            'order_number'      => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal'          => session('subtotal'),
            'discount_percent'  => session('discountvalue'),
            'discount_amount'   => session('discountprice'),
            'gst_percent'       => 18,
            'gst_amount'        => session('gstvalue'),
            'grand_total'       => session('grandtotal'),
            'payment_method'    => 'cod',
            'payment_status'    => 'pending',
            'order_status'      => 'pending',
            'customer_name'     => $request->firstname . ' ' . $request->lastname,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'pincode'           => $request->postcode
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'price'      => $item->price,
                'total'      => $item->qty * $item->price,
            ]);
        }
        session(['order_id' => $order->id]);

        return response()->json([
            'status'  => true,
            'message' => 'Order created, proceed to payment',
            'order_id' => $order->id
        ]);
    }
}
