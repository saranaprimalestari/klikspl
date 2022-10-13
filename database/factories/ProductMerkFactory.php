<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductMerkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(mt_rand(1,2)),
            'slug' => $this->faker->slug(),
            'image' => $this->faker->unique()->sentence(mt_rand(1,2)),
        ];
    }
}
