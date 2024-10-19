<?php

namespace App\Repositories\Order;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function createOrder($userId, $totalPrice): Order;
    public function attachOrderItems($orderId, $products);
}
