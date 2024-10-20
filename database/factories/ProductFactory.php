<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->realText(20),
            'description' => $this->faker->realText(100),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category_id' => \App\Models\Category::factory(),
            'quantity' => $this->faker->numberBetween(0, 100)
        ];
    }
}