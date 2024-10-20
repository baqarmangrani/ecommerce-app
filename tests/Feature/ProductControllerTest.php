<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list products', function () {
    Product::factory()->count(5)->create();

    $response = $this->get(route('products.index'));

    $response->assertStatus(200);
    $response->assertViewHas('paginatedProducts');
});

it('can create a product', function () {
    $category = Category::factory()->create();
    $data = [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 100,
        'quantity' => 10,
        'category_id' => $category->id,
    ];

    $response = $this->post(route('products.store'), $data);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
});

it('can update a product', function () {
    $product = Product::factory()->create();
    $data = [
        'name' => 'Updated Product',
        'description' => 'Updated Description',
        'price' => 150,
        'quantity' => 20,
        'category_id' => $product->category_id,
    ];

    $response = $this->put(route('products.update', $product->id), $data);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
});

it('can delete a product', function () {
    $product = Product::factory()->create();

    $response = $this->delete(route('products.destroy', $product->id));

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});