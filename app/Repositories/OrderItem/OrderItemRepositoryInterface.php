<?php

namespace App\Repositories\OrderItem;

interface OrderItemRepositoryInterface
{
    public function createOrderItem($orderId, $productId, $quantity, $price);
}
