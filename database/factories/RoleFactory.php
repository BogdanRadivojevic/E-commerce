<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['admin', 'customer']),
        ];
    }

    public function admin(): self
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'admin',
        ]);
    }

    public function customer(): self
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'customer',
        ]);
    }
}
