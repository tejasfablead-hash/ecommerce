<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('Admin.Auth.login');
    }


    public function loginmatch(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:4',

        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => 'All fields are Required'
            ], 422);
        }

        $key = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {

            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            return response()->json([
                'status' => false,
                'message' => "Too many login attempts. Try again after {$minutes} Minutes."
            ], 429);
        }
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 300); // 300 sec = 5 min

            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // ✅ Correct login → reset attempts
        RateLimiter::clear($key);

        $request->session()->regenerate();
        $role = Auth::user()->role;
        if ($role === 'admin') {
            $redirect = route('DashboardPage');
        } elseif ($role === 'customer') {
            $redirect = route('HomePage');
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'role' => $role,
            'redirect' => $redirect,
            'message' => 'Login successfully',
        ]);
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Already logged out'
            ], 401);
        }

        $role = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'admin') {
            return response()->json([
                'status' => true,
                'message' => 'Logout Successfully'
            ]);
        } elseif ($role === 'customer') {
            return response()->json([
                'status' => true,
                'message' => 'Logout Successfully'
            ]);
        }
    }


    public function user_login()
    {
        return view('Ecommerce.Auth.login');
    }
    public function user_register()
    {
        return view('Ecommerce.Auth.register');
    }

    public function registration(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'phone'    => 'required|digits:10',
            'image'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'required'
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
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('user', $filename, 'public');
            }

            $user = User::create([
                'role' => 'customer',
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'image' => $filename,
                'address' => $request->address
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Registration Successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Registration failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
