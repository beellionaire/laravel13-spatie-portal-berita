<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
            // membuat judul acak
            'title' => fake()->sentence(mt_rand(4, 8)),

            // membuat 3-5 paragraf acak
            'content' => fake()->paragraphs(mt_rand(3, 5), true),

            // mengambil id user secara acak dari database jika tidak ditentukan
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
