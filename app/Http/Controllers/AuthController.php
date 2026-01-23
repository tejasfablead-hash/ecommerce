<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'message' => 'Login Successfully..'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password..'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
        return response()->json([
            'status' => true,
            'message' => 'Logout Successfully'
        ]);
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
