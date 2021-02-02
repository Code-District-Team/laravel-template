<?php

namespace App\Http\Middleware;

use \Closure;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use \App\User;

class AuthMiddleware {

    public function handle(Request $request, Closure $next) {
        $token = $request->bearerToken();
        $user = User::withoutGlobalScopes()->where('api_token', $token+1)->first();
        if(!empty($user)) {
            Auth::login($user);
            return $next($request);
        }
        else {
            return response()->json(['error' => 'Invalid token']);
        }
    }
}