 @extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-12 container mx-auto">
        <!-- Welcome Section -->
        <div class="col-span-1 lg:col-span-4 bg-white shadow-md rounded px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ $user->name }}!</h1>
            <p class="mt-4 text-gray-600">Your role: <strong>{{ $user->role->name }}</strong></p>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">{{ $num_of_products }}</h2>
                <p class="mt-2">Products</p>
            </div>
            <x-icon name="cube" class="w-6 h-6" />
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">{{ $num_of_orders }}</h2>
                <p class="mt-2">Orders</p>
            </div>
            <x-icon name="shopping-cart" class="w-6 h-6" />
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">${{ number_format($revenue, 2) }}</h2>
                <p class="mt-2">Revenue</p>
            </div>
            <x-icon name="dollar-sign" class="w-6 h-6" />
        </div>
        <div class="bg-gray-600 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">{{ $num_of_product_services }}</h2>
                <p class="mt-2">Services</p>
            </div>
            <x-icon name="service" class="w-6 h-6" />
        </div>

        <!-- Quick Actions -->
        <div class="col-span-1 lg:col-span-4 bg-white shadow-md rounded px-8 py-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-primary-button href="/">Go to Home</x-primary-button>
                <x-success-button href="{{ route('product.create') }}">Add New Product</x-success-button>
                <x-secondary-button href="/services">Manage Services</x-secondary-button>
                <x-primary-button href="{{ route('orders.index') }}">View Orders</x-primary-button>
            </div>
        </div>
    </div>
@endsection
