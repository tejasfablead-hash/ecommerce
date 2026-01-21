<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WishlistsController extends Controller
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $wishlistCount = 0;

            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with('wishlistCount', $wishlistCount);
        });
    }
    public function toggle(Request $request)
{
    $wishlist = Wishlist::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->first();

    if ($wishlist) {
        $wishlist->delete();
    } else {
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);
    }

    $count = Wishlist::where('user_id', Auth::id())->count();

    return response()->json([
        'status' => true,
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
}
