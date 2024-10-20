<?php

namespace App\Repositories\Order;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function all($paginate = null);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function createOrder($userId, $totalPrice): Order;
    public function attachOrderItems($orderId, array $orderItems);
}
