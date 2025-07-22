<?php

namespace App\QueryBuilder;

use App\Models\User;
use Illuminate\Http\Request;

class UserQueryBuilder extends QueryBuilder
{

    public function __construct()
    {
        parent::__construct(User::query());
    }


    public function applyFilters(Request $request): QueryBuilder
    {
        $this->search($request);

        return $this;
    }

    public function search(Request $request)
    {
        // Apply search filter if 'search' is present in the request
        if ($search = $request->input('search')) {
            $this->query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        return $this;
    }
}
