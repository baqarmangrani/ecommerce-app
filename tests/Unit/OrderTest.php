<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $order = Order::factory()->create();
        $this->assertInstanceOf(User::class, $order->user);
    }

    /** @test */
    public function it_has_order_items()
    {
        $order = Order::factory()->create();
        OrderItem::factory()->create(['order_id' => $order->id]);
        $this->assertTrue($order->orderItems()->exists());
    }
}