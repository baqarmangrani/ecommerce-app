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

    /** @test */
    public function it_cannot_restock_product_below_zero()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create(['quantity' => 10]);

        $this->expectException(\Exception::class);

        // Attempt to reduce stock more than available
        $repository->reduceStock($product->id, 15);
    }

    /** @test */
    public function it_can_find_a_product_by_id()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create();

        $foundProduct = $repository->find($product->id);

        $this->assertInstanceOf(Product::class, $foundProduct);
        $this->assertEquals($product->id, $foundProduct->id);
    }

    /** @test */
    public function it_fails_to_find_a_non_existent_product()
    {
        $repository = new ProductRepository();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        // Attempt to find a non-existent product
        $repository->find(9999);
    }

    /** @test */
    public function it_can_get_low_stock_products()
    {
        $repository = new ProductRepository();
        Product::factory()->create(['quantity' => 5]);
        Product::factory()->create(['quantity' => 15]);

        $lowStockProducts = $repository->getLowStockProducts(10);

        $this->assertCount(1, $lowStockProducts); // Only one product should be low stock
        $this->assertEquals(5, $lowStockProducts[0]->quantity);
    }

    /** @test */
    public function it_fails_to_update_product_with_invalid_data()
    {
        $repository = new ProductRepository();
        $product = Product::factory()->create();

        $this->expectException(\Illuminate\Database\QueryException::class);

        // Attempt to update product with invalid data
        $repository->update($product->id, [
            'name' => 'Invalid Product',
            'description' => 'Invalid description',
            'price' => -50, // Invalid price
            'quantity' => 20,
            'category_id' => 1,
        ]);
    }

    /** @test */
    public function it_can_create_multiple_products()
    {
        $repository = new ProductRepository();

        // Assuming your repository has a method for bulk creation
        $productsData = [
            [
                'name' => 'Product 1',
                'description' => 'Description 1',
                'price' => 100,
                'quantity' => 10,
                'category_id' => 1,
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description 2',
                'price' => 150,
                'quantity' => 5,
                'category_id' => 1,
            ],
        ];

        foreach ($productsData as $data) {
            $repository->create($data);
        }

        foreach ($productsData as $data) {
            $this->assertDatabaseHas('products', ['name' => $data['name']]);
        }
    }
}