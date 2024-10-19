<?php

namespace App\Repositories\OrderItem;

use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function createOrderItem($orderId, $productId, $quantity, $price)
    {
        return OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }
}
