<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCommentFactory extends Factory
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
            'product_id' => mt_rand(1,100),
            'comment' => collect($this->faker->paragraphs(mt_rand(2,5)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'star' =>mt_rand(1,5),
            'comment_date' => $this->faker->dateTime->format('Y-m-d'),
            // 'comment_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'order_id' => mt_rand(1,5),
            'deadline_to_comment' => $this->faker->dateTime->format('Y-m-d'),
            // 'deadline_to_comment' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'reply_comment_id' => mt_rand(1,200),
            'comment_image' => Str::random(10),
            'admin_id' => mt_rand(1,4),
        ];
    }
}
