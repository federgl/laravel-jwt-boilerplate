<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace App\Providers;

use Dingo\Api\Auth\Provider\JWT;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        app('Dingo\Api\Auth\Auth')->extend('jwt', static function ($app) {
            return new JWT($app['Tymon\JWTAuth\JWTAuth']);
        });
    }
}
