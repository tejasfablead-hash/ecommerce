<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function filter(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()
            ], 422);
        }

        $query = Product::query();
        if (!empty($request->category)) {
            $query->whereHas('getcategory', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('discount')) {
            $query->where('discount', '=', $request->discount);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('getcategory', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $allowedSorts = ['price', 'name', 'discount', 'discount_value', 'created_at', 'status'];
        if ($request->filled('sort_by') && in_array($request->sort_by, $allowedSorts)) {
            $query->orderBy($request->sort_by, $request->sort_order ?? 'asc');
        }

        $perPage = $request->filled('per_page') ? (int)$request->per_page : 10;
        $products = $query->with(['getcategory', 'wishlists', 'getcart'])->paginate($perPage);

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Product not available'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => ' Products Available ',
            'total_products' => $products->total(),
            'current_page_count' => $products->count(),
            'data' => $products
        ], 200);
    }
    public function show()
    {
        $products = Product::with(['getcategory'])->paginate(10);

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Product not Available'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => ' Products Available ',
            'total_products' => $products->total(),
            'current_page_count' => $products->count(),
            'data' => $products
        ], 200);
    }
    public function showById(Request $request)
    {
        $product = Product::with(['getcategory'])->find($request->id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not Available'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => ' Product Available ',
            'data' => $product
        ], 200);
    }
    public function addtocart(Request $request)
    {
        if (Auth::check()) {
            $authUser = Auth::user()->id;
        } else {
            $authUser = $request->user_id;
        }

        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);
        $user = User::find($authUser);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $cartItem = Cart::where('product_id', $request->product_id)
            ->where('user_id', $user->id)
            ->first();

        if ($cartItem) {
            $cartItem->qty += $request->qty;
            $cartItem->save();
        } else {
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'price' => $request->price
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully',
            'data' => $cartItem ?? $cart
        ], 200);
    }
    public function delete(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()
            ], 422);
        }

        $cartItem = Cart::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product removed from cart successfully'
        ], 200);
    }

}
