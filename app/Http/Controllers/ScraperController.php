<?php

namespace App\Http\Controllers;

use App\Services\ScraperService;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index()
    {
        return view('Admin.Product.scrape'); 
    }

 public function scrapeProducts(Request $request, ScraperService $scraper)
    {
        $result = $scraper->scrape();

        if ($result['status']) {
            return response()->json([
                'success' => true,
                'message' => 'Products scraped successfully!',
                'products' => $result['products']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error']
            ]);
        }
    }
}
