@extends('layout.app')

@section('title', 'Your Cart')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Cart Section -->
        <x-section class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Your Cart</h2>

            <!-- Flash & Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($cartItems->isEmpty() || $cartTotal == null)
                <div class="text-center text-lg text-gray-600">
                    <p>Your cart is empty.
                        <a href="{{ route('product.index') }}" class="text-blue-500 hover:text-blue-600 font-semibold">
                            Browse Products
                        </a>
                    </p>
                </div>
            @else
                <div class="space-y-8">
                    @foreach ($cartItems as $order)
                        @foreach ($order->products as $product)
                            <div class="cart-item flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('product.show', $product) }}">
                                        <img src="{{ asset($product->imageUrl()) }}" alt="{{ $product->model }}" class="w-20 h-20 object-cover rounded-md">
                                    </a>
                                    <div>
                                        <a href="{{ route('product.show', $product) }}">
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $product->brand }} - {{ $product->model }}</h3>
                                        </a>
                                        <p class="text-sm text-gray-500">Price: ${{ number_format($product->price, 2) }}</p>
                                        <p class="text-sm text-gray-500">Quantity: {{ $product->pivot->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-lg font-semibold text-gray-800">
                                    Total: ${{ number_format($product->pivot->quantity * $product->price, 2) }}
                                </div>
                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <!-- Total Price -->
                <div class="mt-8 border-t pt-4 flex justify-between items-center">
                    <p class="text-2xl font-semibold text-gray-800">Total: ${{ number_format($cartTotal, 2) }}</p>
                    <div class="space-x-6">
                        <x-primary-button href="{{ route('cart.complete') }}" class="px-6 py-3">Proceed to Checkout</x-primary-button>
                        <x-secondary-button href="{{ route('product.index') }}" class="py-3 px-6 ">Continue Shopping</x-secondary-button>
                    </div>
                </div>
            @endif
        </x-section>
    </div>
@endsection
