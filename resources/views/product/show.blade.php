@extends('layout.app')

@section('title', $product->brand . ' - ' . $product->model)

@section('content')
    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-4xl mx-auto mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-12">
        <div class="flex flex-wrap items-center">
            <img src="{{ asset( $product->imageUrl()) }}" alt="{{ $product->model }}" class="w-96 h-96 object-cover rounded-lg mr-5">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-800">{{ $product->brand }} - {{ $product->model }}</h2>
                <p class="text-xl text-gray-600 mt-2">Price: <span class="font-semibold text-green-600">${{ number_format($product->price, 2) }}</span></p>
                @auth
                    @if(Auth::user()->isAdmin())
                        <p class="text-sm text-gray-600">Stock: {{ $product->stock }}</p>
                    @endif
                @endauth
                <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>

                @auth
                    <div class="mt-6 flex justify-between">
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('product.edit', $product) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">Edit Product</a>
                            <form action="{{ route('product.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                            </form>
                        @endif
                    </div>
                @endauth
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="quantity" value="1"> <!-- Default quantity can be set here -->
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Add to Cart</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('product.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md">Back to Products</a>
    </div>
@endsection
