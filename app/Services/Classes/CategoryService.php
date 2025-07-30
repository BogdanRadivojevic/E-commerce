<?php

namespace App\Services\Classes;

use App\Models\Category;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryService implements ICategoryService
{

    public function getAll(): Collection
    {
        return Category::all();
    }

    public function store(Request $request): void
    {
        // TODO: Implement store() method.
    }

    public function update(Request $request, Category $category): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
