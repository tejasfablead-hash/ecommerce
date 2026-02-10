<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        
       if ($request->is('api/*')) {
            if (! Auth::guard('sanctum')->check()) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            Auth::shouldUse('sanctum');
            return $next($request);
        }

            if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            } else {
                if ($request->is('admin/*')) {
                    return redirect()->route('LoginPage'); // Admin login page
                } else {
                    return redirect()->route('UserLoginPage'); // User login page
                }
            }
        }


        return $next($request);
    }
}
