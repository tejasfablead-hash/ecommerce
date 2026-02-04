<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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

    public function productdetail($id = null)
    {
        if (empty($id)) {
            return view('Ecommerce.Pages.productdetail', [
                'product' => null
            ]);
        }

        $product = Product::find($id);

        return view('Ecommerce.Pages.productdetail', compact('product'));
    }
    public function products()
    {
        $product = Product::orderBy('created_at', 'desc')
            ->get();
        return view('Ecommerce.Pages.product', compact('product'));
    }
}
