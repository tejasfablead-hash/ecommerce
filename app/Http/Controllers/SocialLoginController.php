<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
     public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => bcrypt(Str::random(16)),
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            }

            Auth::login($user);

            return redirect()->route('HomePage');

        } catch (\Exception $e) {
            return redirect()->route('UserLoginPage')->with('error', 'Google login failed');
        }
    }
}
