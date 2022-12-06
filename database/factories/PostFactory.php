<?php

namespace Database\Factories;

use App\Models\PostState;
use App\Models\Source;
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
            'source_id' => fn () => Source::factory()->create()->id,
            'created_at' => now()->subDays($this->faker->numberBetween(0, 30)),
            'state' => $this->faker->randomElement([
                PostState::PENDING,
                PostState::PUBLISHED,
            ]),
        ];
    }

    public function published(): self
    {
        return $this->state(function () {
            return [
                'state' => PostState::PUBLISHED,
            ];
        });
    }

    public function pending(): self
    {
        return $this->state(function () {
            return [
                'state' => PostState::PENDING,
            ];
        });
    }
}
