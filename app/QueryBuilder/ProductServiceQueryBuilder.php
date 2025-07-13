<?php

namespace App\QueryBuilder;

use App\Models\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductServiceQueryBuilder extends QueryBuilder
{

    public function __construct()
    {
        parent::__construct(\App\Models\ProductService::query());
    }


    public function applyFilters(Request $request): QueryBuilder
    {
        $this->filterByAuthenticatedUser($request);
        $this->filterByStatus($request);

        return $this;
    }

    private function filterByAuthenticatedUser(Request $request): self
    {
        if ($request->has('auth_user') && $request->auth_user) {
            $this->query->where('auth_user_id', auth()->id());
        }
        return $this;
    }

    private function filterByStatus(Request $request): self
    {
        if ($request->has('repaired') && $request->repaired){
            $this->query->where('status', ProductService::STATUS_REPAIRED);
        }
        return $this;
    }

    public function applySorting(Request $request): self
    {
        if ($request->has('sort')) {
            // Safely split the sort value into column and direction
            $sortParts = explode('-', $request->get('sort'), 2);
            $sortColumn = $sortParts[0] ?? 'created_at'; // Default column
            $sortDirection = $sortParts[1] ?? 'desc';    // Default direction

            // Validate the sort direction
            $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'asc';

            $this->query->orderBy($sortColumn, $sortDirection);
        } else {
            $this->query->latest();
        }
        return $this;
    }

}
