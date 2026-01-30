<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIChatController extends Controller
{
    public function ask(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $userId = Auth::id();

        if ($this->containsKeywords($message, ['order'])) {
            return $this->handleOrderQuery($userId);
        }

        if ($this->containsKeywords($message, ['active', 'popular'])) {
            return $this->handleTrendingProducts();
        }

        if ($this->containsKeywords($message, ['available', 'products', 'stock'])) {
            return $this->handleAvailableProducts();
        }

        if ($this->containsKeywords($message, ['price'])) {
            return $this->handleProductPriceQuery($message);
        }

        if ($this->containsKeywords($message, ['project', 'flow'])) {
            return $this->handleProjectFlow();
        }

        return response()->json([
            'reply' => "
            🤖 <b>I can help you with:</b><br>
            • Order status<br>
            • Product price<br>
            • Available products<br>
            • Trending products<br>
            • Project flow
            "
        ]);
    }

    private function containsKeywords(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }

    private function handleOrderQuery(int $userId)
    {
        $order = Order::where('user_id', $userId)->latest()->first();

        if (!$order) {
            return response()->json(['reply' => "❌ You don't have any orders yet."]);
        }

        return response()->json([
            'reply' => "📦 Your latest order <b>{$order->order_number}</b> is currently <b>{$order->order_status}</b>."
        ]);
    }

    private function handleTrendingProducts()
    {
        $products = Product::orderBy('sales_count', 'desc')->take(5)->get();

        if ($products->isEmpty()) {
            return response()->json(['reply' => 'No trending products right now.']);
        }

        $reply = "🔥 <b>Trending Products:</b><br>";
        foreach ($products as $product) {
            $reply .= "• {$product->name} – ₹{$product->price}<br>";
        }

        return response()->json(['reply' => $reply]);
    }

    private function handleAvailableProducts()
    {
        $products = Product::where('qty', '>', 0)->take(5)->get();

        if ($products->isEmpty()) {
            return response()->json(['reply' => '❌ No products available right now.']);
        }

        $reply = "🛒 <b>Available Products:</b><br>";
        foreach ($products as $product) {
            $reply .= "• {$product->name} – ₹{$product->price}<br>";
        }

        return response()->json(['reply' => $reply]);
    }

    private function handleProductPriceQuery(string $message)
    {
        $keywords = array_filter(explode(' ', str_replace('price', '', $message)));

        $product = Product::where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('name', 'LIKE', "%{$word}%");
            }
        })->first();

        if ($product) {
            return response()->json([
                'reply' => "💰 <b>{$product->name}</b> costs <b>₹{$product->price}</b>."
            ]);
        }

        return response()->json(['reply' => "❓ I couldn't find that product. Try full name."]);
    }

    private function handleProjectFlow()
    {
        return response()->json([
            'reply' => "
            🧠 <b>Ecommerce Project Flow:</b><br>
            1️⃣ User browses products<br>
            2️⃣ Adds product to cart<br>
            3️⃣ Checkout & order creation<br>
            4️⃣ Payment (COD / PayPal)<br>
            5️⃣ Order confirmation<br>
            6️⃣ Admin updates order status<br>
            7️⃣ SMS & notifications sent<br>
            8️⃣ Order delivered
            "
        ]);
    }
}
