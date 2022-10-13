<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_product_id' => mt_rand(1,100),
            'name' => $this->faker->unique()->sentence(mt_rand(1,2)),
        ];
    }
}
