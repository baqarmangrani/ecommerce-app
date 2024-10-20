<?php

namespace Tests\Unit;

use App\Events\OrderFailed;
use App\Models\Order;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderFailedTest extends TestCase
{
    /** @test */
    public function it_dispatches_order_failed_event()
    {
        Event::fake();

        $order = Order::factory()->create();
        $exception = new \Exception('Order failed');
        event(new OrderFailed($order, $exception));

        Event::assertDispatched(OrderFailed::class, function ($event) use ($order, $exception) {
            return $event->order->id === $order->id && $event->exception->getMessage() === $exception->getMessage();
        });
    }
}