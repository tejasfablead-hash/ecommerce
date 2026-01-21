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
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $product->price
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Product added to cart'
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
