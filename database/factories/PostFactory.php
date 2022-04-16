<?php

namespace Database\Factories;

use App\Models\PostState;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->words($this->faker->numberBetween(2, 10), true),
            'url' => 'https://stitcher.io',
            'source_id' => 1,
            'created_at' => now()->subDays($this->faker->numberBetween(0, 30)),
            'state' => $this->faker->randomElement([
                PostState::PENDING,
                PostState::PUBLISHED,
            ]),
        ];
    }
}
