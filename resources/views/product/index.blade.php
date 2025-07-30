@extends('layout.app')

@section('title', 'Products')

@section('content')
    <section class="space-y-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <!-- Category dropdown -->
            <form method="GET" action="{{ route('product.index') }}">
                <select name="category_id"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    <option value="" {{ request()->has('category_id') ? '' : 'selected' }}>All Categories</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                    @auth
                        @if(auth()->user()->isAdmin())
                            <option value="null" {{ request('category_id') === 'null' ? 'selected' : '' }}>
                                Uncategorized
                            </option>
                        @endif
                    @endauth
                </select>
            </form>
            <!-- Sorting Controls -->
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-600">Sort by:</span>
                    <a href="{{ route('product.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'order' => request('order') == 'desc' ? 'asc' : 'desc'])) }}"
                       class="text-blue-600 hover:text-blue-800">Date</a> |
                    <a href="{{ route('product.index',  array_merge(request()->all(), ['sort_by' => 'brand', 'order' => request('order') == 'desc' ? 'asc' : 'desc'])) }}"
                       class="text-blue-600 hover:text-blue-800">Name</a> |
                    <a href="{{ route('product.index',  array_merge(request()->all(), ['sort_by' => 'price', 'order' => request('order') == 'desc' ? 'asc' : 'desc'])) }}"
                       class="text-blue-600 hover:text-blue-800">Price</a>
                </div>
            </div>

            <!-- Search bar -->
            <form method="GET" action="{{ route('product.index') }}" class="flex space-x-2 items-end">
                <div>
                    <x-form-input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        aria-label="Search products"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 w-64"
                    />
                </div>
                <button
                    type="submit"
                    aria-label="Submit search"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg h-10"
                >
                    Search
                </button>
            </form>
        </div>


        <!-- Product List -->
        @if($products->isEmpty())
            <div class="text-center text-lg text-gray-600">
                <p>No products found.</p>
                @auth()
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('product.create') }}" class="text-blue-600 hover:text-blue-800">Add a
                            product</a>
                    @endif
                @endauth
            </div>
        @else
            @foreach($products as $product)
                <div class="flex flex-wrap items-center bg-white p-5 rounded-lg shadow-md">
                    <a href="{{ route('product.show', $product) }}">
                        <img src="{{  $product->imageUrl() }}" alt="{{ $product->model }}"
                             class="w-24 h-24 object-cover rounded-lg mr-5">
                    </a>
                    <div class="flex flex-1 flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <a href="{{ route('product.show', $product) }}">
                                <h2 class="text-lg font-bold text-gray-800">{{ $product->brand }}
                                    - {{ $product->model }}</h2>
                            </a>
                            <p class="text-sm text-gray-600 mt-2">Price: <span
                                    class="font-semibold text-green-600">${{ number_format($product->price, 2) }}</span>
                            </p>
                            <p class="text-sm text-gray-600 {{ $product->category_id == null ? 'text-red-600' : '' }}">
                                Category: {{ $product->category->name ?? 'Uncategorized' }}</p>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <!-- Check if user is admin -->
                                    <p class="text-sm text-gray-600 {{ $product->stock == 0 ? 'text-red-600' : '' }}">
                                        Stock: {{ $product->stock }}</p>
                                @endif
                            @endauth
                        </div>
                        <x-primary-button href="{{ route('product.show', $product) }}">
                            View Details
                        </x-primary-button>
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    <div class="mt-6">
        {{ $products->appends(request()->except('page'))->links() }}
    </div>
@endsection
