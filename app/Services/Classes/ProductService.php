<?php

namespace App\Services\Classes;

use App\Models\Product;
use App\QueryBuilder\ProductQueryBuilder;
use App\Services\Interfaces\IProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductService implements IProductService
{
    public function index(Request $request): LengthAwarePaginator
    {
        $user = Auth::user();

        $queryBuilder = new ProductQueryBuilder();

        if (!($user && $user->isAdmin())) {
            $queryBuilder->getQuery()->where('stock', '>', 0);
        }

        $queryBuilder->applyFilters($request);

        return $queryBuilder->getQuery()->latest()->paginate(5);
    }

    public function store(Request $request): Product
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $product = new Product($validatedData);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image_path = $imagePath;
        }

        $product->save();

        return $product;
    }

    public function update(Request $request, Product $product): Product
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $product->fill($validatedData);

        if ($request->hasFile('image')) {
            $oldImagePath = $product->image_path;

            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image_path = $imagePath;

            if ($oldImagePath && !filter_var($oldImagePath, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $product->save();

        return $product;
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }
}
