<?php

namespace App\Services;

interface IOrderService
{

    public function getUserOrders();

    public function getOrderDetails($orderId);

    public function finalizeOrder();
    public function getOrders();
}
