<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('Ecommerce.Layout.index');
    }

    public function home()
    {
        $product = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Ecommerce.Pages.home', compact('product'));
    }
    public function products()
    {
        $product = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Ecommerce.Pages.product', compact('product'));
    }

    public function category(Request $request)
    {
    
        $category = Category::with('getproduct')->withCount('getproduct')->get();
        // dd($category);
        return view('Ecommerce.Pages.category', compact(['category']));

    }
  
    
    public function confirm()
    {
        return view('Ecommerce.Pages.confirm');
    }
    public function blog()
    {
        return view('Ecommerce.Pages.blog');
    }
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('Ecommerce.Pages.productdetail', compact('product'));
    }
    public function contact()
    {
        return view('Ecommerce.Pages.contact');
    }
    public function profile()
    {
        return view('Ecommerce.Pages.profile');
    }
    public function product($id)
    {
        $product = Product::where('category_id', $id)->get();
        return view('Ecommerce.Pages.product', compact('product'));
    }
}
