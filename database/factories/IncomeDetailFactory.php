<?php

namespace Database\Factories;

use App\Models\IncomeDetail;
use App\Models\Income;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomeDetail>
 */
class IncomeDetailFactory extends Factory
{
    protected $model = IncomeDetail::class;

    public function definition(): array
    {
        $purchase_price = $this->faker->randomFloat(2, 10, 100);
        $sale_price = $this->faker->randomFloat(2, $purchase_price * 1.2, $purchase_price * 2);

        return [
            'income_id' => Income::factory(),
            'product_id' => Product::factory(),
            'amount' => $this->faker->numberBetween(1, 10),
            'purchase_price' => $purchase_price,
            'sale_price' => $sale_price,
        ];
    }
} 