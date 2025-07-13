<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\QueryBuilder\ProductQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // fixme: PREBACITI U PRODUCTSERVICE!!!

    public function index()
    {
        $user = Auth::user();

        // Create a new ProductQueryBuilder instance
        $queryBuilder = new ProductQueryBuilder();

        // Apply the stock filter if the user is not an admin
        if (!($user && $user->isAdmin())) {
            $queryBuilder->getQuery()->where('stock', '>', 0);
        }

        // Apply additional filters and sorting
        $queryBuilder->applyFilters(request());

        // Get the final query with pagination
        $products = $queryBuilder
            ->getQuery()
            ->latest()
            ->paginate(5);

        return view('product.index', ['products' => $products]);
    }

    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        // Validate the data
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        // Create the product with validated data
        $product = new Product();
        $product->brand = $validatedData['brand'];
        $product->model = $validatedData['model'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->description = $validatedData['description'];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Store the image
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image_path = 'storage/' . $imagePath;
        }

        // Save the product
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully!');

    }

    // Show the edit form for a specific product
    public function edit(Product $product)
    {
        // Return the edit view with the specific product
        return view('product.edit', compact('product'));
    }

    // Update the specified product
    public function update(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $product->brand = $validatedData['brand'];
        $product->model = $validatedData['model'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            // Proverava da li je 'image_path' postavljen (da slika postoji) i da li 'image_path' nije validan URL.
            // Funkcija filter_var sa parametrom FILTER_VALIDATE_URL se koristi da se proveri da li je putanja URL.
            // Ako putanja nije validan URL, znači da je to lokalna putanja do slike koja se nalazi na serveru,
            // pa možemo da je obrišemo sa 'unlink'.
            if ($product->image_path && !filter_var($product->image_path, FILTER_VALIDATE_URL)) {
                // Proverava da li datoteka postoji na zadatoj putanji u javnom direktorijumu aplikacije.
                // Ako datoteka postoji, može se sigurno obrisati kako bi se oslobodio prostor na disku.
                if (file_exists(public_path($product->image_path))) {
                    unlink(public_path($product->image_path));
                }
            }

            // Store the new image
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image_path = 'storage/' . $imagePath;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete the product from the database
        $product->delete();

        // Redirect to the product index page with a success message
        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
