<?php

namespace App\Services\Interfaces;

use App\Models\ProductService;
use Illuminate\Http\Request;

interface IProductServiceService
{
    public function getFilteredServices(Request $request);
    public function createService(array $data): ProductService;
    public function updateService(ProductService $service, array $data): ProductService;
    public function deleteService(ProductService $service): void;
    public function finishService(ProductService $service, $validate): void;
    public function countService(): int;

    public function getServices();
}
