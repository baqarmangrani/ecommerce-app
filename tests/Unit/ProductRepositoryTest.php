<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\Product\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Category::factory()->create(['id' => 1, 'name' => 'Test Category']); // Ensure a category exists
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $repository = new ProductRepository();

        $product = $repository->create([
            'name' => 'Test Product',
            'description' => 'Test description',
            'price' => 100,
            'quantity' => 10,
            'category_id' => 1,
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create();

        $updatedProduct = $repository->update($product->id, [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 150,
            'quantity' => 20,
            'category_id' => 1,
        ]);

        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create();

        $deletedProduct = $repository->delete($product->id);

        $this->assertInstanceOf(Product::class, $deletedProduct);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_can_restock_a_product()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create(['quantity' => 10]);

        $restockedProduct = $repository->restock($product->id, 10);

        $this->assertInstanceOf(Product::class, $restockedProduct);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'quantity' => 20]);
        $this->assertDatabaseHas('inventory_logs', [
            'product_id' => $product->id,
            'quantity_change' => 10,
            'type' => 'addition',
            'comments' => 'Restocked 10 units.',
        ]);
    }
}