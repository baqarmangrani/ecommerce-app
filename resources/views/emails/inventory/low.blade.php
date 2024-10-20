<!DOCTYPE html>
<html>

<head>
    <title>Low Inventory Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        .product-details {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Low Inventory Alert</h1>
    <p>Dear Admin,</p>
    <p>The inventory for the following product has fallen below the threshold:</p>

    <div class="product-details">
        <p><strong>Product Name:</strong> {{ $product->name }}</p>
        <p><strong>Current Stock:</strong> {{ $product->quantity }}</p>
    </div>

    <p>Please restock the product as soon as possible.</p>
</body>

</html>
