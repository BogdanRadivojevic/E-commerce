<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private IProductService $productService;
    private ICategoryService $categoryService;

    public function __construct(IProductService $productService, ICategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->index($request);

        $categories = $this->categoryService->getAll();

        return view('product.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->productService->store($request);

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = $this->categoryService->getAll();

        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->productService->update($request, $product);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product);

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
