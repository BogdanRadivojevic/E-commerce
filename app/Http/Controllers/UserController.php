<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\QueryBuilder\UserQueryBuilder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $queryBuilder = new UserQueryBuilder();

        $queryBuilder->applyFilters($request);

        $users = $queryBuilder->getQuery()
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
