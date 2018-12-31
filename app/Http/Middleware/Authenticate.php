<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Class Authenticate.
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function redirectTo($request): string
    {
        return '/home ';
    }
}
