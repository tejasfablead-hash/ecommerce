<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('Ecommerce.Auth.forgot-password');
    }

    public function sendResetLink(Request $request)
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

        $resetLink = url('/reset-password/' . $token);


        Mail::send('Ecommerce.Auth.reset-password-email', ['link' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Password');
        });

        return response()->json([
            'status' => true,
            'message' => 'Reset link sent to your email!',
            'link' => $resetLink
        ]);
    }
    public function showResetForm($token)
    {
        return view('Ecommerce.Auth.reset-password', compact('token'));
    }
    public function resetPassword(Request $request)
    {
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
