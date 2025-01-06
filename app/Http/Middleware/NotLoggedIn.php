<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $checkplz = [
            'Auth check: ' => Auth::check(),
            'Current route name: ' => [$request->route()->getName()]
        ];
        // dd('Debugging: ' . json_encode($checkplz));

        // Donot Allow access to the login and registration routes if user authenticated
        if (Auth::check() && in_array($request->route()->getName(), [
            'login.page',
            'login.show',
            'login.do',
            'register.emp.page',
            'register.client.page',
            'reset.page',
            'reset.form',
            'reset.send',
            'reset.do',
        ])) {
            return redirect()->route('userpanels'); // Redirect to the user panel or dashboard
        }

        return $next($request);
    }
}
