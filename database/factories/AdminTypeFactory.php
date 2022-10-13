<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_type' => $this->faker->unique()->sentence(mt_rand(1,2)),
            'slug' => $this->faker->slug()
        ];
    }
}
