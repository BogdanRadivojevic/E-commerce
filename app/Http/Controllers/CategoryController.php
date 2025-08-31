<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private ICategoryService $category;

    public function __construct(ICategoryService $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->getAll();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->category->store($request);

        return redirect()
            ->route('categories.index')
            ->with('message', 'Category created successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $this->category->update($request, $category);
        return response()->json(['message' => 'Category updated successfully']);
    }

    public function destroy(Category $category)
    {
        $this->category->delete($category);

        return redirect()->route('categories.index')->with('message', 'Category deleted successfully!');
    }

}
