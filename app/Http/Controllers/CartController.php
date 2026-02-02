<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function cart()
    {
        $cartItems = Cart::with('getproduct')
            ->where('user_id', Auth::id())
            ->get();

        return view('Ecommerce.Pages.cart', compact('cartItems'));
    }
    public function addtoCart(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        $product = Product::findOrFail($request->product_id);
        $qty = $request->qty ?? 1;

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('qty', $qty);
            return response()->json([
                'status' => true,
                'message' => 'Cart is Updated.'
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $product->price
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('qty');

        return response()->json([
            'status' => true,
            'cart_count' => $cartCount,
            'message' => 'Product added to cart'
        ]);
    }
    public function cartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        $cartCount = Cart::where('user_id', Auth::id())->sum('qty');
        return response()->json([
            'count' => $cartCount
        ]);
    }


    public function continueShopping()
    {
        session()->forget([
            'subtotal',
            'gstvalue',
            'discountvalue',
            'discountprice',
            'grandtotal',
        ]);

        return redirect()->route('UserCartPage');
    }



    public function update(Request $request)
    {

        $request->validate([
            'cartId' => 'required|exists:carts,id',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('id', $request->cartId)->where('user_id', Auth::id())
            ->first();
        if (!$cart) {
            return response()->json(['status' => false]);
        }
        $updateqty = $cart->update([
            'qty' => $request->qty
        ]);
        return response()->json([
            'status' => true,
            'qty' => $updateqty
        ]);
    }

    public function delete($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ]);
        }

        $cart->delete();
        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
