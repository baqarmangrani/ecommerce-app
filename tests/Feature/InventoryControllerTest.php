<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user); // Authenticate user
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create(['category_id' => $this->category->id, 'quantity' => 10]);
    }

    /** @test */
    public function it_can_restock_a_product_with_valid_quantity()
    {
        $response = $this->putJson(route('products.restock', $this->product->id), [
            'quantity' => 5,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['id' => $this->product->id, 'quantity' => 15]);
        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $this->product->id,
            'quantity_change' => 5,
            'type' => 'addition',
            'comments' => 'Restocked 5 units.',
        ]);
    }

    /** @test */
    public function it_fails_to_restock_with_invalid_quantity()
    {
        $response = $this->putJson(route('products.restock', $this->product->id), [
            'quantity' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantity']);
    }

    /** @test */
    public function it_fails_to_restock_a_non_existent_product()
    {
        $response = $this->putJson(route('products.restock', 9999), [
            'quantity' => 5,
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_creates_inventory_log_on_restock()
    {
        $this->putJson(route('products.restock', $this->product->id), [
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $this->product->id,
            'quantity_change' => 5,
            'type' => 'addition',
            'comments' => 'Restocked 5 units.',
        ]);
    }
}