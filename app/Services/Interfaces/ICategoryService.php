<?php

namespace App\Services\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ICategoryService
{
    public function getAll(): Collection;

    public function store(Request $request): void;

    public function update(Request $request, Category $category): void;

    public function delete(Category $category): void;
}
