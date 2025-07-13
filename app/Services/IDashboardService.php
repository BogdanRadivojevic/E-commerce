<?php

namespace App\Services;

interface IDashboardService
{

    public function countProducts();
    public function countOrders();
    public function revenue();
    public function countServices();


}
