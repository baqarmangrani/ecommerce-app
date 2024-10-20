<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an order', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['quantity' => 10]);

    $data = [
        'products' => [
            ['product_id' => $product->id, 'quantity' => 2],
        ],
        'payment_method' => 'credit_card',
        'card_number' => '1234567812345678',
        'expiry_date' => '12/23',
        'cvv' => '123',
    ];

    $response = $this->actingAs($user)->post(route('orders.store'), $data);

    $response->assertRedirect(route('orders.index'));
    $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
    $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 2]);
});