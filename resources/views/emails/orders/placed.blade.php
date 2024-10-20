<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        .order-details,
        .order-items {
            margin-top: 20px;
        }

        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-items th,
        .order-items td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .order-items th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Order Confirmation</h1>
    <p>Dear {{ $order->user->name }},</p>
    <p>Thank you for your order. Here are the details:</p>

    <div class="order-details">
        <p><strong>Order Number:</strong> {{ $orderNumber }}</p>
        <p><strong>Total Price:</strong> ${{ number_format($totalPrice, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($status) }}</p>
        <p><strong>Payment Status:</strong> {{ ucfirst($paymentStatus) }}</p>
    </div>

    <div class="order-items">
        <h2>Order Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p>Thank you for shopping with us!</p>
</body>

</html>
