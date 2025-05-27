<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->generateProductName();
        $imagePath = $this->generateProductImage($name);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'code' => $this->faker->unique()->bothify('PROD-####-????'),
            'stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->sentence(),
            'image' => $imagePath,
            'status' => (string) $this->faker->randomElement(['1', '0']),
        ];  
    }

    /**
     * Populates Products names.
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

    /**
     * Generates and saves a product image.
     */
    private function generateProductImage(string $name): string
    {
        // Asegurarse de que el directorio existe
        $directory = storage_path('app/public/products');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generar un nombre de archivo único basado en el nombre del producto
        $filename = Str::slug($name) . '.jpg';
        $fullPath = $directory . '/' . $filename;

        // Generar una imagen de placeholder con el nombre del producto
        $image = imagecreatetruecolor(640, 480);
        
        // Colores
        $bgColor = imagecolorallocate($image, 
            $this->faker->numberBetween(0, 200),
            $this->faker->numberBetween(0, 200),
            $this->faker->numberBetween(0, 200)
        );
        $textColor = imagecolorallocate($image, 255, 255, 255);
        
        // Rellenar el fondo
        imagefill($image, 0, 0, $bgColor);
        
        // Agregar el texto del nombre del producto
        $text = wordwrap($name, 30, "\n", true);
        $lines = explode("\n", $text);
        
        $y = 200;
        foreach ($lines as $line) {
            $textWidth = strlen($line) * 7; // Aproximación del ancho del texto
            $x = (640 - $textWidth) / 2;
            imagestring($image, 5, $x, $y, $line, $textColor);
            $y += 30;
        }
        
        // Guardar la imagen
        imagejpeg($image, $fullPath, 90);
        imagedestroy($image);

        return 'products/' . $filename;
    }
} 