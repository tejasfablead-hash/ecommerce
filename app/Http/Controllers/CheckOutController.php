<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{

    public function storeGrandTotal(Request $request)
    {
        session([
            'grandtotal' => $request->grandTotal,
            'discountprice' => $request->discountprice,
            'gstvalue' => $request->gstvalue,
            'discountvalue' => $request->discountvalue,
            'subtotal' => $request->subtotal,
        ]);

        return response()->json(['status' => true]);
    }
    public function checkout(Request $request)
    {
        $grandtotal = session('grandtotal', 0);
        $discountprice = session('discountprice', 0);
        $gstvalue = session('gstvalue', 0);
        $discountvalue = session('discountvalue', 0);
        $subtotal = session('subtotal', 0);

        $cart = Cart::with('getproduct')->where('user_id', Auth::id())->get();

        // if ($cart->count() == 0) {
        //     return redirect()->route('UserProductPage')
        //         ->with('error', 'Your cart is empty');
        // }

        return view('Ecommerce.Pages.checkout', compact(['cart', 'grandtotal', 'discountprice', 'gstvalue', 'discountvalue', 'subtotal']));
    }
}
