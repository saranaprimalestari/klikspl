<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
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
            'variant_name' => $this->faker->sentence(mt_rand(1,2)),
            'variant_slug' => $this->faker->slug(),
            'variant_value' => $this->faker->sentence(mt_rand(1,2)),
            'variant_code' => $this->faker->unique()->numberBetween(1000, 9999),
            'stock' => mt_rand(1,20),
            'sold' => mt_rand(1,20),
            'weight' =>  mt_rand(1000,5000),
            'price' =>  mt_rand(20000,2000000),
            'promo_id' => mt_rand(1,3),
        ];
    }
}