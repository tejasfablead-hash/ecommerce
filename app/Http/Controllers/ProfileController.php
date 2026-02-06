<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::id();
        if ($user == true) {
            $orders = Order::where('user_id', $user)
                ->where('payment_status', 'paid')
                ->latest()
                ->limit(4)
                ->with(['orderitem.product'])
                ->get();
      
        }
        return view('Ecommerce.Pages.profile', compact(
            'orders'
        ));
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $updateuser = User::where('id', $id)->first();
        $newimage = $updateuser->image;

        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($updateuser->id),
            ],
            'phone'    => 'required|digits:10',
            'image'    => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => 'All fields are Required'
            ], 422);
        }
        try {
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete('user/' . $updateuser->image);
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('user', $filename, 'public');
                $newimage = $filename;
            }

            $updateuser->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $newimage,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully',
                'user' => $updateuser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Profile Updated Failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function feedback(Request $request)
{
    $userId = Auth::id();

    $validator = Validator::make($request->all(), [
        'order_id'   => 'required|exists:orders,id',
        'product_id' => 'required|exists:products,id',
        'rating'     => 'required|integer|min:1|max:5',
        'message'    => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $alreadyGiven = Feedback::where([
        'order_id'   => $request->order_id,
        'product_id' => $request->product_id,
        'user_id'    => $userId,
    ])->exists();

    if ($alreadyGiven) {
        return response()->json([
            'status' => false,
            'message' => 'Feedback already submitted for this product'
        ], 409);
    }

    Feedback::create([
        'order_id'   => $request->order_id,
        'user_id'    => $userId,
        'product_id' => $request->product_id,
        'rating'     => $request->rating,
        'message'    => $request->message,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Feedback submitted successfully'
    ], 201);
}


    public function viewfeedback()
    {
        $feedback = Feedback::all();
        return view('Admin.Feedback.view', compact('feedback'));
    }
}
