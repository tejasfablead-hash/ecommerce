<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|digits:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'address' => 'required|string|max:255'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('user', $filename, 'public');
        }

        $user = User::create([
            'role' => 'customer',
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'image' => $filename,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registration successful',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()
            ], 422);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }
    }


    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Logout Successfully'
        ]);
    }

    public function user(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'user' => $user,
        ]);
    }
  
}
