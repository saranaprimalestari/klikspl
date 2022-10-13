<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
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
            'type' => $this->faker->sentence(mt_rand(1,2)),
            'account_number' => mt_rand(1111111,9999999),
            'code' => mt_rand(1111111,9999999),
            'description' => collect($this->faker->paragraphs(mt_rand(5,6)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'logo' => NULL,
        ];
    }
}
