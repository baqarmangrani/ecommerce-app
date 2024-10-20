<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        Category::factory()->create(['id' => 1, 'name' => 'Test Category']); // Ensure a category exists
    }

    /** @test */
    public function it_can_create_a_product_through_the_controller()
    {
        $response = $this->post(route('products.store'), [
            'name' => 'New Product',
            'description' => 'Test description',
            'price' => 100,
            'quantity' => 10,
            'category_id' => 1,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }

    /** @test */
    public function it_can_retrieve_a_product_through_the_controller()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product->id));

        $response->assertStatus(200);
        $response->assertViewHas('product', $product);
    }

    /** @test */
    public function it_can_update_a_product_through_the_controller()
    {
        $product = Product::factory()->create();

        $response = $this->put(route('products.update', $product->id), [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 150,
            'quantity' => 20,
            'category_id' => 1,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    /** @test */
    public function it_can_delete_a_product_through_the_controller()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_can_restock_a_product_through_the_controller()
    {
        $product = Product::factory()->create(['quantity' => 10]); // Create a product with initial quantity

        $response = $this->put(route('products.restock', $product->id), [ // Change to PUT method
            'quantity' => 10, // Restock with 10 units
        ]);

        $response->assertRedirect(route('products.index')); // Check for redirect
        $this->assertDatabaseHas('products', ['id' => $product->id, 'quantity' => 20]); // Check new quantity
        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $product->id,
            'quantity_change' => 10,
        ]); // Check if inventory log exists
    }
}