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
        $product = Product::orderBy('created_at', 'desc')
            ->get();
        return view('Ecommerce.Pages.home', compact('product'));
    }

    public function contact()
    {
        return view('Ecommerce.Pages.contact');
    }
}
