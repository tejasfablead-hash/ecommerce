<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminPasswordController extends Controller
{
    public function index()
    {
        return view('Admin.Auth.forgot-password');
    }
    public function forgotPassword(Request $request)
    {

       $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/admin/reset-password/' . $token);


        Mail::send('Admin.Auth.reset-password-email', ['link' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Password');
        });

        return response()->json([
            'status' => true,
            'message' => 'Reset link sent to your email!',
            'link' => $resetLink
        ]);
    }
    public function showResetForm(Request $request,$token)
    {
        $reset = PasswordReset::where('token', $request->token)->first();
        return view('Admin.Auth.reset-password', compact(['token','reset']));
    }
    public function resetPassword(Request $request){
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = PasswordReset::where('token', $request->token)->first();

        if (!$reset) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token'
            ]);
        }

       
        User::where('email', $reset->email)
            ->update(['password' => Hash::make($request->password)]);

        PasswordReset::where('email', $reset->email)->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully!'
        ]);
    }
}
