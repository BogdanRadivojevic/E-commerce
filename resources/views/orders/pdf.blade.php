<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<h1>Completed Orders</h1>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>User</th>
        <th>Total Price</th>
        <th>Products</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->user->name }}</td>
            <td>${{ number_format($order->total_price, 2) }}</td>
            <td>
                @foreach ($order->products as $product)
                    {{ $product->brand }} {{ $product->model }} (x{{ $product->pivot->quantity }})<br>
                @endforeach
            </td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
