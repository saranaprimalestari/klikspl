<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusDetailFactory extends Factory
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
            'status' => $this->faker->sentence(mt_rand(1,2)),
            'status_detail' => $this->faker->sentence(mt_rand(1,10)),
            'status_date' => $this->faker->dateTime($format = 'Y-m-d H:i:s', $max = 'now'),
        ];
    }
}
