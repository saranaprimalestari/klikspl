<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserNotificationFactory extends Factory
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
            'slug' => $this->faker->slug(),
            'type' => $this->faker->word,   
            'description' => collect($this->faker->paragraphs(mt_rand(2,4)))->map(function ($p){
                return "<p>$p</p>";
            })->implode(''),
            'excerpt' => $this->faker->sentence(mt_rand(10,20)),
            'image' => $this->faker->filePath,
            'is_read' => mt_rand(0, 1),
        ];
    }
}