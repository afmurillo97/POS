<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'voucher_type' => $this->faker->randomElement(['Sale Ticket', 'Sale Receipt', 'Credit Note', 'Invoice']),
            'voucher_number' => $this->faker->unique()->numerify('SALE-####'),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'tax' => $this->faker->randomFloat(2, 0, 18),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];
    }
} 