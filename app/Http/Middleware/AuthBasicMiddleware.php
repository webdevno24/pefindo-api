<?php

namespace App\Http\Middleware;

use Closure;

class AuthBasicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            $request->headers->get('php-auth-user') == env('APP_USER') &&
            $request->headers->get('php-auth-pw') == env('APP_PW')
        ) {
            return $next($request);
        }
        abort(403);
    }
}
