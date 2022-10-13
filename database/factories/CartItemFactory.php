<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => mt_rand(1,5),
            'product_id' => mt_rand(1,20),
            'product_variant_id' => mt_rand(1,100),
            'sender_address_id' => mt_rand(1,3),
            'quantity' => mt_rand(1,5),
            'subtotal' => mt_rand(20000,2000000),
            
        ];
    }
}
