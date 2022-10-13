<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => mt_rand(1,5),
            'user_id' => mt_rand(1,5),
            'product_id' => mt_rand(1,100),
            'product_variant_id' => mt_rand(1,100),
            'order_product_id' => mt_rand(1,100),
            'quantity' => mt_rand(1,5),
            'price' => $this->faker->randomDigit,
            'total_price_item' =>  $this->faker->randomDigit,
            'is_review' => $this->faker->randomDigitNotNull(),
            'order_item_status' =>Str::random(1),
            'retur' => Str::random(1),
        ];
    }
}
