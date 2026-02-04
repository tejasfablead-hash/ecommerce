<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\SMSService;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function order(Request $request, SMSService $sms)
    {
        // dd($request->all());
        $user = Auth::id();
        $cartItems = Cart::where('user_id', $user)->with('getproduct')->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
           
        return response()->json([
            'status'  => true,
            'message' =>'Your cart is empty'
        ]);
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
            'order_number'   => 'TMP-' . time(),
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
        $phone = $request->phone;
        if (!str_starts_with($phone, '+')) {
            $phone = '+91' . $phone; 
        }

        $sms->send(
            $phone,
            "✅ Order Confirmed Successfully!
            Order No: {$order->order_number}
            Amount: ₹{$order->grand_total}
            Thank you for shopping with us. "
        );

        session(['order_id' => $order->id]);

        return response()->json([
            'status'  => true,
            'message' => 'Order created, proceed to payment',
            'order_id' => $order->id
        ]);
    }

    public function view()
    {
        $order = Order::with([
            'getcustomer',
            'orderitem.product'
        ])->latest()->paginate(10);

        return view('Admin.Order.view', compact('order'));
    }
    public function details($id)
    {
        $order = Order::where('id', $id)->with([
            'getcustomer',
            'orderitem.product'
        ])->latest()->first();
        return view('Admin.Order.details', compact('order'));
    }
    public function customer()
    {
        $user = User::all();
        return view('Admin.Order.customer', compact('user'));
    }

    public function getNotifications()
    {
        $orders = Order::where('order_status', 'confirmed')->with([
            'getcustomer',
            'orderitem.product'
        ])->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $count = $orders->count();
        return response()->json([
            'count' => $count,
            'orders' => $orders
        ]);
    }

    public function updateorder(Request $request, SMSService $sms)
    {
        $order = Order::findOrFail($request->order_id);

        if (in_array($order->order_status, ['delivered', 'cancelled'])) {
            return response()->json([
                'status' => false,
                'message' => 'Delivered order cannot be changed'
            ], 403);
        }

        $paymentStatus = match ($request->order_status) {
            'delivered' => 'paid',
            'cancelled' => 'cancelled',
            default     => 'pending',
        };

        $order->update([
            'order_status'   => $request->order_status,
            'payment_status' => $paymentStatus
        ]);

        $phone = str_starts_with($order->phone, '+') ? $order->phone : '+91' . $order->phone;
        $message = null;
        if ($request->order_status === 'delivered') {

            if (!$order->feedback_token) {
                $order->update([
                    'feedback_token' => Str::uuid(),
                    'feedback_given' => false
                ]);
            }

            $link = url('/feedback/' . $order->feedback_token);

            $message = "📦 Order Delivered!
                        Order: {$order->order_number}
                        Please give feedback:
                        {$link}";
        } else {
            $message = match ($request->order_status) {
                'confirmed' => "✅ Order {$order->order_number} CONFIRMED",
                'shipped'   => "🚚 Order {$order->order_number} SHIPPED",
                'cancelled' => "❌ Order {$order->order_number} CANCELLED",
            };
        }

        if (!empty($message)) {
            $sms->send($phone, $message);
        }
        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully'
        ]);
    }
}
