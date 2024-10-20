<?php

namespace Tests\Feature;

use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_processes_an_order()
    {
        Queue::fake();

        $order = Order::factory()->create();
        $orderItems = OrderItem::factory()->count(3)->create(['order_id' => $order->id])->toArray();

        ProcessOrder::dispatch($order, $orderItems);

        Queue::assertPushed(ProcessOrder::class, function ($job) use ($order) {
            $reflection = new \ReflectionClass($job);
            $property = $reflection->getProperty('order');
            $property->setAccessible(true);
            $jobOrder = $property->getValue($job);

            return $jobOrder->id === $order->id;
        });
    }
}