<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
      $user = User::count();
      $category = Category::count();
      $product = Product::count();
      return view('Admin.Dashboard.dashboard', compact('user', 'category', 'product'));
   }
}
