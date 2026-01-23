<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
      $category = Category::count();
      $product  = Product::count();
      $order    = Order::count();
      $user     = User::where('role', 'customer')->count();

      /* ====== REVENUE ====== */
      $totalRevenue = Order::where('payment_status', 'paid')
         ->sum('grand_total');

      $months = collect([
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ]);

        /* ======================
            MONTHLY ORDERS
        ====================== */
        $ordersRaw = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyOrders = $months->mapWithKeys(function ($month, $index) use ($ordersRaw) {
            return [
                $month => $ordersRaw[$index + 1] ?? 0
            ];
        });

        /* ======================
            MONTHLY REVENUE
        ====================== */
        $revenueRaw = Order::selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyRevenue = $months->mapWithKeys(function ($month, $index) use ($revenueRaw) {
            return [
                $month => $revenueRaw[$index + 1] ?? 0
            ];
        });

        /* ======================
            LATEST ORDERS
        ====================== */
        $latestOrders = Order::with('getcustomer')
            ->latest()
            ->take(5)
            ->get();


      return view('Admin.Dashboard.dashboard', compact(
         'category',
         'product',
         'order',
         'user',
         'totalRevenue',
         'monthlyOrders',
         'monthlyRevenue',
         'latestOrders'
      ));
   }
}
