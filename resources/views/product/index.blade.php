@extends('layout.app')

@section('title', 'Products')

@section('content')
    <section class="space-y-6">
        <!-- Sorting Controls -->
        <div class="flex justify-between items-center">
            <div>
                <span class="text-gray-600">Sort by:</span>
                <a href="{{ route('product.index', ['sort_by' => 'created_at', 'order' => request('order') == 'desc' ? 'asc' : 'desc']) }}"
                   class="text-blue-600 hover:text-blue-800">Date</a> |
                <a href="{{ route('product.index', ['sort_by' => 'brand', 'order' => request('order') == 'desc' ? 'asc' : 'desc']) }}"
                   class="text-blue-600 hover:text-blue-800">Name</a> |
                <a href="{{ route('product.index', ['sort_by' => 'price', 'order' => request('order') == 'desc' ? 'asc' : 'desc']) }}"
                   class="text-blue-600 hover:text-blue-800">Price</a>
            </div>
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
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->model }}"
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
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <!-- Check if user is admin -->
                                    <p class="text-sm text-gray-600">Stock: {{ $product->stock }}</p>
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
