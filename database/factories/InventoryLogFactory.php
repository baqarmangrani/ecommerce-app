<?php

namespace Database\Factories;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryLog>
 */
class InventoryLogFactory extends Factory
{
    protected $model = InventoryLog::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'quantity_change' => $this->faker->numberBetween(-100, 100),
            'type' => $this->faker->randomElement(['addition', 'subtraction']),
            'comments' => $this->faker->realText(100),
        ];
    }
}
