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
                ->with(['orderitem.product'])
                ->get();
        }
        return view('Ecommerce.Pages.profile', compact('orders'));
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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email'    => 'required|email',
            'subject' => 'required|integer|min:1|max:5',
            'message'    => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => 'All fields are Required'
            ], 422);
        }
        try {

            $user = Feedback::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Feedback Send Succcessfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Feedback Send failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
