<?php

namespace Database\Factories;

use App\Models\ProductService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductService>
 */
class ProductServiceFactory extends Factory
{
    protected $model = ProductService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auth_user_id' => User::factory(), // Create a auth user
            'service_user_id' => User::factory(), // Create a related service user
            'device_name' => $this->faker->word() . ' ' . $this->faker->numerify('Model ###'), // Random device name
            'issue_description' => $this->faker->sentence(10), // Random issue description
            'price' => $this->faker->randomFloat(2, 50, 500), // Random price between 50 and 500
            'status' => $this->faker->randomElement([
                ProductService::STATUS_PENDING,
                ProductService::STATUS_IN_PROGRESS,
//                ProductService::STATUS_COMPLETED,
                ProductService::STATUS_FINISHED,
            ]), // Random status
        ];
    }
}
