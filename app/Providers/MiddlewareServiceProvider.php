<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{

    /* fixme:
     * if the middleware doesn't work, return to classical approach (Middleware::class)
     * instead of using MiddlewareServiceProvider
    */
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->router->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
        $this->app->router->aliasMiddleware('forceJsonResponse', \App\Http\Middleware\ForceJsonResponse::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
