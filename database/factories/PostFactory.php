<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 3),
            'title' => 'Title '. rand(1, 100),
            'body' => fake()->realText(1500),
            'image' => 'https://dummyimage.com/850x350/dee2e6/6c757d.jpg'
        ];
    }
}
