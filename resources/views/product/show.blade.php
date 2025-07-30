@extends('layout.app')

@section('title', "$product->brand - $product->model")

@section('content')
    {{-- Flash messages --}}
    @if(session('success') || session('error'))
        <div class="max-w-4xl mx-auto mt-4">
            <div class="{{ session('success') ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }}
                        border px-4 py-3 rounded relative"
                 role="alert">
                <strong class="font-bold">
                    {{ session('success') ? 'Success!' : 'Error!' }}
                </strong>
                <span class="block sm:inline">
                    {{ session('success') ?? session('error') }}
                </span>
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8 mt-12 flex flex-col md:flex-row gap-8">
        {{-- Product Image --}}
        <div class="flex-shrink-0 mx-auto">
            <img src="{{ asset($product->imageUrl()) }}"
                 alt="{{ $product->model }}"
                 class="w-80 h-80 object-cover rounded-lg shadow">
        </div>

        {{-- Product Details --}}
        <div class="flex-1">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                {{ $product->brand }} - {{ $product->model }}
            </h1>
            <p class="text-xl text-green-600 font-semibold mb-4">
                ${{ number_format($product->price, 2) }}
            </p>

            <p class="text-sm text-gray-600 mb-2">
                Category:
                <span class="font-medium text-gray-800">{{ $product->category?->name ?? 'Uncategorized' }}</span>
            </p>

            @auth
                @if(Auth::user()->isAdmin())
                    <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                @endif
            @endauth

            <p class="mt-4 text-gray-700 leading-relaxed">
                {{ $product->description }}
            </p>

            {{-- Actions --}}
            <div class="mt-6 space-y-4">
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-wrap gap-4 items-center">
                        @csrf
                        <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            value="1"
                            min="1"
                            max="{{ $product->stock }}"
                            class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring focus:ring-green-200"
                        >
                        <button
                            type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 rounded-lg shadow">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <p class="text-red-600 font-medium">Out of stock</p>
                @endif

                @auth
                    @if(Auth::user()->isAdmin())
                        <div class="flex gap-4 mt-4">
                            <a href="{{ route('product.edit', $product) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                                Edit
                            </a>
                            <form action="{{ route('product.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="mt-6">
                <a href="{{ route('product.index') }}"
                   class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                    ← Back to Products
                </a>
            </div>
        </div>
    </div>
@endsection
