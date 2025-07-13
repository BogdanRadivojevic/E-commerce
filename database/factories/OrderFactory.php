<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Nasumično generisanje statusa narudžbine
        $statuses = [$this->model::STATUS_PENDING, $this->model::STATUS_COMPLETED, $this->model::STATUS_CANCELED];

        return [
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement($statuses), // Nasumičan status
//            'total_price' => function () {
//                // Generišemo nasumične cene proizvoda u narudžbini
//                $productPrices = collect(range(1, $this->faker->numberBetween(1, 5))) // 1 do 5 proizvoda
//                ->map(fn() => $this->faker->randomFloat(2, 10, 500)); // Cena po proizvodu (10 do 500)
//                return $productPrices->sum(); // Ukupna cena proizvoda
//            },//fixme: mozda trebam da vratim ovo!
        ];
    }
}
