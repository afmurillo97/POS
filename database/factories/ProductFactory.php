<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->generateProductName(),
            'code' => $this->faker->unique()->bothify('PROD-####-????'),
            'stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(640, 480, 'product'),
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];  
    }

     /**
     * Populates Products names.
     *
     */
    private function generateProductName(): string
    {
        $productTypes = [
            'Laptop', 'Smartphone', 'Tablet', 'Monitor', 
            'Keyboard', 'Mouse', 'Printer', 'SSD', 
            'Router', 'Webcam'
        ];
        
        $brands = [
            'HP', 'Dell', 'Samsung', 'Apple', 
            'Logitech', 'Sony', 'Lenovo', 'Asus',
            'Acer', 'MSI'
        ];
        
        $features = [
            'Pro', 'Max', 'Elite', 'Gaming', 
            'Ultra', 'Plus', 'XT', 'Limited', 
            'Edition', 'Turbo'
        ];

        return sprintf(
            '%s %s %s %s',
            $this->faker->randomElement($brands),
            $this->faker->randomElement($productTypes),
            $this->faker->randomElement($features),
            $this->faker->numberBetween(1000, 9999)
        );
    }
} 