<?php

namespace App\Providers;

use App\Services\Classes\CartService;
use App\Services\Classes\OrderService;
use App\Services\Classes\ProductService;
use App\Services\Classes\ProductServiceService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\IProductServiceService;
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
        $this->app->bind(IProductService::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
