<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition(): array
    {
        $sale_price = $this->faker->randomFloat(2, 10, 200);
        $discount = $this->faker->randomFloat(2, 0, $sale_price * 0.2); // Up to 20% discount

        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'amount' => $this->faker->numberBetween(1, 5),
            'sale_price' => $sale_price,
            'discount' => $discount,
        ];
    }
} 