<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ParentCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
   public function index()
   {
      $category = ParentCategory::all();
      return view('Admin.Category.insert', compact('category'));
   }
   public function store(Request $request)
   {
      $validate = Validator::make($request->all(), [
         'category' => 'required',
         'subcategory' => 'required',
         'image'    => 'required|image|mimes:jpg,jpeg,png'
      ]);
      if ($validate->fails()) {
         return response()->json([
            'status' => false,
            'errors' => $validate->errors()
         ], 422);
      }
      try {
         if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('category', $filename, 'public');
         }

         $category = Category::create([
            'parent_id' => $request->category,
            'name' => $request->subcategory,
            'image' => $filename,
         ]);

         return response()->json([
            'status' => true,
            'message' => 'Category Created Successfully',
            'redirect' => route('CategoryViewPage')
         ], 201);
      } catch (\Exception $e) {
         return response()->json([
            'status'  => false,
            'message' => 'Category Not Created',
            'error'   => $e->getMessage()
         ], 500);
      }
   }
   public function view()
   {
      $category = Category::all();
      return view('Admin.Category.view', compact('category'));
   }

   public function edit($id)
   {
      $category = ParentCategory::all();
      $single = Category::where('id', $id)->first();
      return view('Admin.Category.update', compact(['category', 'single']));
   }
   public function update(Request $request)
   {
      $category = ParentCategory::all();
      $update = Category::where('id', $request->id)->first();
      $new = $update->image;

      $validate = Validator::make($request->all(), [
         'category' => 'required',
         'subcategory' => 'required',
         'image'    => 'image|mimes:jpg,jpeg,png'
      ]);
      if ($validate->fails()) {
         return response()->json([
            'status' => false,
            'errors' => $validate->errors()
         ], 422);
      }
      try {
         if ($request->hasFile('image')) {
            Storage::disk('public')->delete('category/' . $update->image);
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('category', $filename, 'public');
            $new = $filename;
         }

         $update->update([
            'parent_id' => $request->category,
            'name' => $request->subcategory,
            'image' => $new,
         ]);

         return response()->json([
            'status' => true,
            'message' => 'Category Updated Successfully',
            'redirect' => route('CategoryViewPage')
         ], 201);
      } catch (\Exception $e) {
         return response()->json([
            'status'  => false,
            'message' => 'Category Not Updated',
            'error'   => $e->getMessage()
         ], 500);
      }
   }

   public function delete($id)
   {
   
      $delete = Category::find($id);
      
      if (!$delete) {
         return response()->json([
            'status' => false,
            'message' => 'Record Not Available'
         ], 404);
      }
      if ($delete->image && Storage::disk('public')->exists('category/' . $delete->image)) {
         Storage::disk('public')->delete('category/' . $delete->image);
      }
      $delete->delete();
      return response()->json([
         'status' => true,
         'message' => 'Record Deleted Successfully'
      ], 200);
   }
   
    public function category(Request $request)
    {
        $category = Category::with('getproduct')->withCount('getproduct')->get();
        // dd($category);
        $products = Product::all();
        return view('Ecommerce.Pages.category', compact(['category','products']));

    }

    
}
