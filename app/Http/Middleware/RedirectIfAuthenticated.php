<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Guard;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated.
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (GUARD::USER === $guard && Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
