<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards) // Keep return type as mixed
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        } else {
            $this->clearFlashMessages();
            return route('login.page');
        }
    }

    /**
     * Clear flash messages from the session.
     */
    protected function clearFlashMessages()
    {
        if (Session::has('flash.new')) {
            $flashMessages = Session::get('flash.new');
            foreach ($flashMessages as $key => $message) {
                Session::forget('flash.new.' . $key);
            }
        }
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards): void
    {
        // Set a flash message to inform the user they need to log in
        $toast_message = ['You are not authorized to access that page. Please login first!'];
        Session::flash('n_errors', $toast_message);

        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $request->expectsJson() ? null : $this->redirectTo($request)
        );
    }
}
