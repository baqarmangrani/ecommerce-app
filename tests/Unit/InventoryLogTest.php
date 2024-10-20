<?php

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an inventory log', function () {
    $product = Product::factory()->create();

    $data = [
        'product_id' => $product->id,
        'quantity_change' => 10,
        'type' => 'restock',
        'comments' => 'Restocked 10 units',
    ];

    $inventoryLog = InventoryLog::create($data);

    expect($inventoryLog)->toBeInstanceOf(InventoryLog::class);
    expect($inventoryLog->product_id)->toBe($product->id);
});

it('can update an inventory log', function () {
    $inventoryLog = InventoryLog::factory()->create();

    $data = [
        'quantity_change' => 5,
        'comments' => 'Updated comment',
    ];

    $inventoryLog->update($data);

    expect($inventoryLog->quantity_change)->toBe(5);
});

it('can delete an inventory log', function () {
    $inventoryLog = InventoryLog::factory()->create();

    $inventoryLog->delete();

    expect(InventoryLog::find($inventoryLog->id))->toBeNull();
});

it('belongs to a product', function () {
    $inventoryLog = InventoryLog::factory()->create();

    expect($inventoryLog->product)->toBeInstanceOf(Product::class);
});