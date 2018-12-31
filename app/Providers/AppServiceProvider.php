<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use BeyondCode\ErdGenerator\ErdGeneratorServiceProvider;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;
use League\Fractal\Manager;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal() || $this->app->runningUnitTests()) {
            if (true === \class_exists(IdeHelperServiceProvider::class)) {
                $this->app->register(IdeHelperServiceProvider::class);
            }

            if (true === \class_exists(TelescopeServiceProvider::class)) {
                $this->app->register(TelescopeServiceProvider::class);
            }

            if (true === \class_exists(L5SwaggerServiceProvider::class)) {
                $this->app->register(L5SwaggerServiceProvider::class);
            }

            if (true === \class_exists(LaravelLogViewerServiceProvider::class)) {
                $this->app->register(LaravelLogViewerServiceProvider::class);
            }

            if (true === \class_exists(ErdGeneratorServiceProvider::class)) {
                $this->app->register(ErdGeneratorServiceProvider::class);
            }
        }

        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(static function ($app) {
            return new Fractal(new Manager(), 'include', ',');
        });
    }
}
