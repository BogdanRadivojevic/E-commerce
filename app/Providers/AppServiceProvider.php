<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\ICartService;
use App\Services\IOrderService;
use App\Services\IProductServiceService;
use App\Services\OrderService;
use App\Services\ProductServiceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // DI
        $this->app->bind(IOrderService::class, OrderService::class);
        $this->app->bind(ICartService::class, CartService::class);
        $this->app->bind(IProductServiceService::class, ProductServiceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
