<?php

namespace App\Services\Interfaces;

interface IDashboardService
{

    public function countProducts();
    public function countOrders();
    public function revenue();
    public function countServices();


}
