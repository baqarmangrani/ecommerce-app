<?php

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an order', function () {
    $data = [
        'user_id' => 1,
        'order_number' => 'ORD-123456',
        'total_price' => 100,
        'status' => 'pending',
        'payment_status' => 'paid',
        'payment_method' => 'credit_card',
    ];

    $order = Order::create($data);

    expect($order)->toBeInstanceOf(Order::class);
    expect($order->order_number)->toBe('ORD-123456');
});

it('can update an order', function () {
    $order = Order::factory()->create();

    $data = [
        'status' => 'completed',
    ];

    $order->update($data);

    expect($order->status)->toBe('completed');
});

it('can delete an order', function () {
    $order = Order::factory()->create();

    $order->delete();

    expect(Order::find($order->id))->toBeNull();
});