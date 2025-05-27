<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'client_type' => $this->faker->randomElement(['Individual', 'Company']),
            'id_type' => $this->faker->randomElement(['Citizenship Card', 'Foreigner ID', 'Identity card', 'NIT']),
            'id_number' => $this->faker->unique()->numerify('###########'),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];
    }
} 