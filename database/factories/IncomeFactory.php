<?php

namespace Database\Factories;

use App\Models\Income;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::factory(),
            'voucher_type' => $this->faker->randomElement(['Sale Ticket', 'Sale Receipt', 'Credit Note', 'Invoice']),
            'voucher_number' => $this->faker->unique()->numerify('VOU-####'),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'tax' => $this->faker->randomFloat(2, 0, 100),
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];  
    }
} 