<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can restock a product', function () {
    $product = Product::factory()->create(['quantity' => 10]);
    $data = ['quantity' => 5];

    $response = $this->post(route('products.restock', $product->id), $data);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', ['id' => $product->id, 'quantity' => 15]);
});