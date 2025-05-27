<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'id_type' => $this->faker->randomElement(['Citizenship Card', 'Foreigner ID', 'Identity card', 'NIT']),
            'id_number' => $this->faker->unique()->numerify('###########'),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];
    }
} 