<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOriginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city_origin = array(
            36 => '1',
            387 => '2',
            206 => '3'
        );
        $city_ids = array_rand($city_origin);
        $sender_address_id = $city_origin[$city_ids];
        return [
            'product_id' => mt_rand(1, 100),
            'product_variant_id' => mt_rand(1, 200),
            'city_ids' => $city_ids,
            'sender_address_id' => $sender_address_id,
        ];
    }
}
