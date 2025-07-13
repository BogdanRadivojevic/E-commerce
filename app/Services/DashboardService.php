<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductService;

class DashboardService implements IDashboardService
{

    private IOrderService $order;
    private IProductServiceService $productService;
    private IProductServiceService $productServiceService;

    /**
     * @param OrderService $order
     */
    public function __construct(IOrderService $order, IProductServiceService $productService, IProductServiceService $productServiceService)
    {
        $this->order = $order;
        $this->productService = $productService;
        $this->productServiceService = $productServiceService;
    }


    public function countProducts()
    {
        $totalProducts = Product::count();

        return $totalProducts;
    }

    public function countOrders()
    {
        return $this->order->getOrders()->count();
    }

    public function revenue()
    {
        $orders = $this->order->getOrders();
        $productServices = $this->productServiceService->getServices();
        $repairedServices = $productServices->where('status', ProductService::STATUS_REPAIRED);

        $revenue = 0;

        foreach ($orders as $order) {
            $revenue += $order->total_price;
        }

//        dd($repairedServices);

        foreach ($repairedServices as $repairedService) {
            $revenue += $repairedService->price;
        }

        return $revenue;
    }

    public function countServices()
    {
        return $this->productService->countService();
    }

}
