<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'brand' => $this->faker->company, // Nasumično ime brenda
            'model' => $this->faker->word, // Nasumičan naziv modela
            'description' => $this->faker->paragraph, // Nasumičan opis proizvoda
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100), // Dostupna količina na stanju
            'image_path' => $this->faker->imageUrl(640, 480, 'electronics', true), // Nasumičan URL slike
        ];
    }
}
