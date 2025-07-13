<?php

namespace App\QueryBuilder;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryBuilder
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    abstract public function applyFilters(Request $request): self;

    public function getQuery(): Builder
    {
        return $this->query;
    }
}
