<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition()
    {
        return [
            'discount_code' => $this->faker->unique()->bothify('DISCOUNT-####'),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'type' => $this->faker->randomElement(['flat', 'percentage']),
        ];
    }
}
