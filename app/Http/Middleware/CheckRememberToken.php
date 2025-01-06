<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRememberToken
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isRememberTokenExpired()) {
                Auth::logout(); // Log the user out
                return redirect('/login')->withErrors(['Your session has expired. Please log in again!']);
            }
        }

        return $next($request);
    }
}
