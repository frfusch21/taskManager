<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Log;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        Log::info('Authenticating request', [
            'guard' => $guard,
            'is_guest' => Auth::guard($guard)->guest(),
            'user' => Auth::guard($guard)->user(),
            'token' => $request->bearerToken(),
            'check' => Auth::check(),
        ]);

        if (Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                Log::warning('Unauthorized via API request', [
                    'guard' => $guard,
                    'request' => $request->all(),
                ]);
                return response()->json(['message' => 'Unauthorized'], 401);
            } else {
                Log::warning('Unauthorized login via web request', [
                    'guard' => $guard,
                    'request' => $request->all(),
                ]);
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
