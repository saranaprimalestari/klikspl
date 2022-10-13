<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(mt_rand(1,2)),
            'specification' => collect($this->faker->paragraphs(mt_rand(2,4)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'description' => collect($this->faker->paragraphs(mt_rand(5,6)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'excerpt' => $this->faker->sentence(mt_rand(1,5)),
            'slug' => $this->faker->slug(),
            // 'product_code' => $this->faker->unique()->randomLetter(mt_rand(1,13)),
            'product_code' => $this->faker->unique()->numberBetween(1000, 9999),
            'product_category_id' => mt_rand(1,10),
            'product_merk_id' => mt_rand(1,13),
            'stock' => mt_rand(1,10),
            'sold' => mt_rand(1,20),
            'view' => mt_rand(1,100),
            'weight' =>  mt_rand(1000,5000),
            'price' =>  mt_rand(20000,2000000),
            'promo_id' => mt_rand(1,3),
        ];
    }
}
