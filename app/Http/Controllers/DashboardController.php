<?php

namespace App\Http\Controllers;

use App\Services\Classes\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    private DashboardService $dashboardService;

    // DI
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the dashboard index page.
     *
     * This function retrieves the authenticated user and various dashboard statistics,
     * then returns the dashboard view with the collected data.
     *
     * @return \Illuminate\View\View The dashboard index view with user and statistics data.
     */
    public function index()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'num_of_products' => $this->dashboardService->countProducts(),
            'num_of_orders' => $this->dashboardService->countOrders(),
            'revenue' => $this->dashboardService->revenue(),
            'num_of_product_services' => $this->dashboardService->countServices(),
//            'product_service_counts' => $this->dashboardService->productServiceCounts(),
//            'top_selling_products' => $this->dashboardService->topSellingProducts(),
//            'top_selling_product_services' => $this->dashboardService->topSellingProductServices(),
//            'top_customers' => $this->dashboardService->topCustomers(),
        ];

        return view('dashboard.index', $data);
    }

}
