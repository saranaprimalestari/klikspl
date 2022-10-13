<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->userName(),
            'description' => collect($this->faker->paragraphs(mt_rand(5,10)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'excerpt' => $this->faker->paragraph(),
            'slug' => $this->faker->slug(),
            'discount' => mt_rand(000,9999),
            'active' => Str::random(1),
        ];
    }
}
