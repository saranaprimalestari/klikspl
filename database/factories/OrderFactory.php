<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_no' => $this->faker->unique()->word,
            'resi' => $this->faker->unique()->word,
            'user_id' => mt_rand(1,4),
            'sender_address_id' => mt_rand(1,3),
            'order_address_id' => mt_rand(1,10),
            'courier' => $this->faker->name(),
            'courier_package_type' => $this->faker->name(),
            'estimation_day' => mt_rand(0,7),
            'estimation_date' => $this->faker->dateTime,
            // 'estimation' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'courier_price' => $this->faker->randomDigit(),
            'total_price' => mt_rand(11111,999999),
            // 'product_id' => mt_rand(1,20),
            'order_status' => Str::random(1),
            'proof_of_payment' => Str::random(10),
            'retur' => mt_rand(0,1),
            'unique_code' => mt_rand(000,999),
            'payment_method_id' => mt_rand(1,10),
            'payment_due_date' => $this->faker->dateTime,
        ];
    }
}
