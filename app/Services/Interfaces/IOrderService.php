<?php

namespace App\Services\Interfaces;

interface IOrderService
{

    public function getUserOrders();

    public function getOrderDetails($orderId);

    public function finalizeOrder();
    public function getOrders();
}
