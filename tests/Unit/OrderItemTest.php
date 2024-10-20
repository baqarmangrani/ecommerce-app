<?php

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an order item', function () {
    $order = Order::factory()->create();
    $product = Product::factory()->create();

    $data = [
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'price' => 100,
    ];

    $orderItem = OrderItem::create($data);

    expect($orderItem)->toBeInstanceOf(OrderItem::class);
    expect($orderItem->order_id)->toBe($order->id);
});

it('can update an order item', function () {
    $orderItem = OrderItem::factory()->create();

    $data = [
        'quantity' => 5,
        'price' => 150,
    ];

    $orderItem->update($data);

    expect($orderItem->quantity)->toBe(5);
});

it('can delete an order item', function () {
    $orderItem = OrderItem::factory()->create();

    $orderItem->delete();

    expect(OrderItem::find($orderItem->id))->toBeNull();
});

it('belongs to an order', function () {
    $orderItem = OrderItem::factory()->create();

    expect($orderItem->order)->toBeInstanceOf(Order::class);
});

it('belongs to a product', function () {
    $orderItem = OrderItem::factory()->create();

    expect($orderItem->product)->toBeInstanceOf(Product::class);
});