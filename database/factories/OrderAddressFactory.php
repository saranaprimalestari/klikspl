<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderAddressFactory extends Factory
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
            'name' => $this->faker->name(),
            'address' => $this->faker->address,
            'district' => $this->faker->locale,
            'city_ids' => mt_rand(1,501),
            'province_ids' => mt_rand(1,34),
            'postal_code' => mt_rand(000000,999999),
            'telp_no' => $this->faker->phoneNumber,
        ];
    }
}
