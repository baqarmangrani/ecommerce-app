<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order()
    {
        $repository = new OrderRepository();
        $orderData = Order::factory()->make()->toArray();

        $order = $repository->create($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    /** @test */
    public function it_can_find_an_order()
    {
        $repository = new OrderRepository();
        $order = Order::factory()->create();

        $foundOrder = $repository->find($order->id);

        $this->assertInstanceOf(Order::class, $foundOrder);
        $this->assertEquals($order->id, $foundOrder->id);
    }
}