<?php

namespace Tests\Feature;

use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_create_an_order_with_successful_payment()
    {
        Queue::fake(); // Ensure Queue fake is set up before the request

        $product = Product::factory()->create(['quantity' => 10, 'price' => 100]);
        $orderData = [
            'products' => [
                ['product_id' => $product->id, 'quantity' => 1],
            ],
            'payment_method' => 'credit_card',
            'card_number' => '4242424242424242',
            'expiry_date' => '12/23',
            'cvv' => '123',
        ];

        $paymentServiceMock = Mockery::mock(PaymentServiceInterface::class);
        $paymentServiceMock->shouldReceive('processPayment')->andReturn(true);
        $this->app->instance(PaymentServiceInterface::class, $paymentServiceMock);

        $response = $this->post(route('orders.store'), $orderData);

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['user_id' => $this->user->id]);
        Queue::assertPushed(ProcessOrder::class);
    }

    /** @test */
    public function it_can_show_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertViewHas('order', $order);
    }

    /** @test */
    public function it_fails_to_create_an_order_with_failed_payment()
    {
        $product = Product::factory()->create(['quantity' => 10, 'price' => 100]);
        $orderData = [
            'products' => [
                ['product_id' => $product->id, 'quantity' => 1],
            ],
            'payment_method' => 'credit_card',
            'card_number' => '4242424242424242',
            'expiry_date' => '12/23',
            'cvv' => '123',
        ];

        $paymentServiceMock = Mockery::mock(PaymentServiceInterface::class);
        $paymentServiceMock->shouldReceive('processPayment')->andReturn(false);
        $this->app->instance(PaymentServiceInterface::class, $paymentServiceMock);

        $response = $this->post(route('orders.store'), $orderData);

        $response->assertSessionHasErrors(['payment']);
        $this->assertDatabaseMissing('orders', ['user_id' => $this->user->id]);
    }
}