<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function all($paginate = null)
    {
        if ($paginate) {
            return Order::with('user')->paginate($paginate);
        }
        return Order::with('user')->get();
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $data)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return true;
        }
        return false;
    }

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
