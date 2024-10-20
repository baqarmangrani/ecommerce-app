<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function it_can_create_an_order()
    {
        $product = Product::factory()->create();
        $orderData = [
            'products' => [
                ['product_id' => $product->id, 'quantity' => 1],
            ],
            'payment_method' => 'credit_card',
            'card_number' => '1234567812345678',
            'expiry_date' => '12/23',
            'cvv' => '123',
        ];

        $response = $this->post(route('orders.store'), $orderData);

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function it_can_show_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertViewHas('order', $order);
    }
}