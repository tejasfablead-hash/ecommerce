<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('Admin.Product.insert', compact('category'));
    }
    public function store(ProductRequest $request)
    {

        try {
            $path = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $path[] = $file->store('product', 'public');
                }
            }
            $status = $request->qty > 0 ? 'active' : 'inactive';

            Product::create([
                'category_id' => $request->category,
                'name' => $request->product,
                'price' => $request->price,
                'qty' => $request->qty,
                'discount' => $request->discount,
                'discount_value' => $request->discount_value,
                'description' => $request->description,
                'status'      => $status,
                'image' => json_encode($path),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product Created Successfully',
                'redirect' => route('ProductViewPage')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Product Not Created',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function view()
    {
        $product = Product::all();
        return view('Admin.Product.view', compact('product'));
    }
    public function edit($id)
    {
        $category = Category::all();
        $single = Product::where('id', $id)->first();
        return view('Admin.Product.update', compact(['category', 'single']));
    }

    public function update(ProductRequest $request)
    {
        $update = Product::where('id', $request->id)->first();

        try {
            $path = json_decode($update->image ?? '[]', true);

            if ($request->hasFile('image')) {
                foreach ($path as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }

                $path = [];
                foreach ($request->file('image') as $file) {
                    $path[] = $file->store('product', 'public');
                }
            }
            $status = $request->qty > 0 ? 'active' : 'inactive';

            $update->update([
                'category_id' => $request->category,
                'name' => $request->product,
                'price' => $request->price,
                'qty' => $request->qty,
                'discount' => $request->discount,
                'discount_value' => $request->discount_value,
                'description' => $request->description,
                'status'      => $status,
                'image' => json_encode($path),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully',
                'redirect' => route('ProductViewPage')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Product Not Updated',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $delete = Product::find($id);

            if (!$delete) {
                return response()->json([
                    'status' => false,
                    'message' => 'Record Not Available'
                ], 404);
            }

            $paths = json_decode($delete->image ?? '[]', true);
            if (!empty($paths)) {
                foreach ($paths as $oldFile) {
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }

            $delete->delete();

            return response()->json([
                'status' => true,
                'message' => 'Record Deleted Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while deleting the record',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function detail($id)
    {
        $product = Product::where('id', $id)->first();
        return view('Admin.Product.details', compact(['product']));
    }

    public function product($id)
    {

        $product = Product::where('category_id', $id)->get();

        return view('Ecommerce.Pages.product', compact('product'));
    }

    public function productdetail($id)
    {
        $product = Product::findOrFail($id);

        $userId = Auth::id();

        $feedbackOrder = null;

        if ($userId) {
            $feedbackOrder = Order::where('user_id', $userId)
                ->whereIn('order_status', ['delivered', 'Delivered'])
                ->where('payment_status', 'paid')
                ->whereHas('orderitem', function ($q) use ($id) {
                    $q->where('product_id', $id);
                })
                ->whereDoesntHave('getfeedback', function ($q) use ($id, $userId) {
                    $q->where('product_id', $id)
                        ->where('user_id', $userId);
                })
                ->latest()
                ->first();

            $canReview = $feedbackOrder ? true : false;
        }
        // dd($feedbackOrder);
        $feedback = Feedback::where('product_id', $id)
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();
        // dd($feedback);

        return view(
            'Ecommerce.Pages.productdetail',
            compact('product', 'canReview', 'feedbackOrder', 'feedback')
        );
    }

    public function products(Request $request)
    {
        $query = Product::query()->where('status', 'active');

        if ($request->filled('category')) {
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
            $query->where('discount', '>=', $request->discount);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($request->filled('sort_by')) {

            switch ($request->sort_by) {

                case 'price_low_high':
                    $query->orderBy('discount_value', 'asc');
                    break;

                case 'price_high_low':
                    $query->orderBy('discount_value', 'desc');
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'discount_high':
                    $query->orderBy('discount', 'desc');
                    break;

                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $product = $query->get();
        $categories = Category::all();

        return view('Ecommerce.Pages.product', compact('product', 'categories'));
    }
}
