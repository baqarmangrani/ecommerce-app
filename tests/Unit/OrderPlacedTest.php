<?php

namespace Tests\Unit;

use App\Events\OrderPlaced;
use App\Models\Order;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderPlacedTest extends TestCase
{
    /** @test */
    public function it_dispatches_order_placed_event()
    {
        Event::fake();

        $order = Order::factory()->create();
        event(new OrderPlaced($order));

        Event::assertDispatched(OrderPlaced::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
    }
}