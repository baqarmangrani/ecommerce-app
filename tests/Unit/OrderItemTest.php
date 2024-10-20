<?php

namespace Tests\Unit;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_order()
    {
        $orderItem = OrderItem::factory()->create();
        $this->assertInstanceOf(Order::class, $orderItem->order);
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $orderItem = OrderItem::factory()->create();
        $this->assertInstanceOf(Product::class, $orderItem->product);
    }
}