<?php

namespace App\Jobs;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\OrderPlaced;
use App\Events\OrderFailed;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $orderItems;

    public function __construct(Order $order, array $orderItems)
    {
        $this->order = $order;
        $this->orderItems = $orderItems;
    }

    public function handle(OrderRepositoryInterface $orderRepository, ProductRepositoryInterface $productRepository)
    {
        try {
            $order = $this->order;
            $orderItems = $this->orderItems;

            $orderRepository->attachOrderItems($order->id, $orderItems);

            foreach ($orderItems as $item) {
                $productRepository->reduceStock($item['product_id'], $item['quantity']);
            }

            event(new OrderPlaced($order));
        } catch (\Exception $e) {
            // Trigger the OrderFailed event
            event(new OrderFailed($order, $e));
        }
    }
}
