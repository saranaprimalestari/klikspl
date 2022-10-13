<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDeliveryStatusFactory extends Factory
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
            'delivery_status' => $this->faker->sentence(mt_rand(1,2)),
            'delivery_status_detail' => $this->faker->sentence(mt_rand(1,2)),
            'delivery_date' => $this->faker->dateTime($format = 'Y-m-d H:i:s', $max = 'now'),
        ];
    }
}
