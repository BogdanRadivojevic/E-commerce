<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface IProductService
{
    public function index(Request $request): LengthAwarePaginator;

    public function store(Request $request): Product;

    public function update(Request $request, Product $product): Product;

    public function destroy(Product $product): void;
}
