@extends('layout.app')

@section('title', 'Completed Orders')

@section('content')
    <section class="bg-white p-5 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-5">Completed Orders</h2>

        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border">#</th>
                <th class="p-3 border">User</th>
                <th class="p-3 border">Total Price</th>
                <th class="p-3 border">Products</th>
                <th class="p-3 border">Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td class="p-3 border">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>                    <td class="p-3 border">{{ $order->user->name }}</td>
                    <td class="p-3 border">${{ number_format($order->total_price, 2) }}</td>
                    <td class="p-3 border">
                        @foreach ($order->products as $product)
                            <span>{{ $product->brand }} {{ $product->model }} (x{{ $product->pivot->quantity }})</span><br>
                        @endforeach
                    </td>
                    <td class="p-3 border">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center border">No completed orders found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-5">
            <form action="{{ route('orders.generatePDF') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white font-semibold rounded-lg px-4 py-2 hover:bg-blue-700 transition duration-200">
                    Generate PDF
                </button>
            </form>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </section>
@endsection
