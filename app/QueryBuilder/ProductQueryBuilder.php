<?php

namespace App\QueryBuilder;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductQueryBuilder extends QueryBuilder
{

    public function __construct($query = null)
    {
        parent::__construct($query ?? Product::query());
    }

    // Apply filters based on the request
    public function applyFilters(Request $request): self
    {
        $this->applySorting($request);
        $this->applySearch($request);

        return $this;
    }

    // Applying sorting logic based on the request
    public function applySorting(Request $request): self
    {
        if ($request->has('sort_by') && in_array($request->input('sort_by'), ['created_at', 'brand', 'price'])) {
            $sortBy = $request->input('sort_by');
            $order = $request->input('order', 'desc');
            $this->query->orderBy($sortBy, $order);
        }

        return $this;
    }

    public function applySearch(Request $request): self
    {
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $this->query->where(function ($query) use ($searchTerm) {
                $query->where('brand', 'like', '%' . $searchTerm . '%')
                    ->orWhere('model', 'like', '%' . $searchTerm . '%');
            });
        }
        return $this;
    }
}
