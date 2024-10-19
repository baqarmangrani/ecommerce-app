<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder($userId, $totalPrice): Order
    {
        return Order::create([
            'user_id' => $userId,
            'total_price' => $totalPrice,
        ]);
    }

    public function attachOrderItems($orderId, $products)
    {
        foreach ($products as $productData) {
            OrderItem::create([
                'order_id' => $orderId,
                'product_id' => $productData['id'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
            ]);
        }
    }
}
