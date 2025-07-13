<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = Order::where('status', Order::STATUS_COMPLETED)
            ->with('products')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $order = $this->orderService->getOrderDetails($orderId);
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $order = $this->orderService->finalizeOrder();
        return redirect()->route('orders.index')->with('success', 'Narudžbina je uspešno kreirana.');
    }

    public function generatePDF()
    {
        $orders = Order::where('status', Order::STATUS_COMPLETED)->with('products')->get();
        $pdf = Pdf::loadView('orders.pdf', compact('orders'));
        return $pdf->download('completed_orders.pdf');
    }
}
