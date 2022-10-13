<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => mt_rand(1,100),
            'name' => $this->faker->unique()->sentence(mt_rand(1,2)),
            // 'slug' => $this->faker->slug()
        ];
    }
}
