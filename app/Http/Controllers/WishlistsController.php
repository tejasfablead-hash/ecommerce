<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WishlistsController extends Controller
{
    public function toggle(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $count = Wishlist::where('user_id', Auth::id())->count();
            return response()->json([
                'status' => true,
                'type' => 'exists',
                'count' =>  $count
            ]);
        } else {
            $create = Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
           
        }

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'status' => true,
            'type' => 'added',
            'count' => $count
        ]);
    }

    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('Ecommerce.Pages.wishlist', compact('wishlists'));
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function view()
    {
        $wishlist = Wishlist::with('product', 'customer')->get();
        // dd($wishlist);
        return view('Admin.Product.wishlist', compact('wishlist'));
    }
}
