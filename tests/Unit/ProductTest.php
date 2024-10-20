<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a product', function () {
    $data = [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 100,
        'quantity' => 10,
        'category_id' => 1,
    ];

    $product = Product::create($data);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('Test Product');
});

it('can update a product', function () {
    $product = Product::factory()->create();

    $data = [
        'name' => 'Updated Product',
        'description' => 'Updated Description',
        'price' => 150,
        'quantity' => 20,
        'category_id' => 1,
    ];

    $product->update($data);

    expect($product->name)->toBe('Updated Product');
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $product->delete();

    expect(Product::find($product->id))->toBeNull();
});