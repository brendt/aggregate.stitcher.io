<?php

namespace Database\Factories;

use App\Models\SourceState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Test Source',
            'url' => 'https://example.com',
            'state' => SourceState::PUBLISHED,
        ];
    }

    public function published(): self
    {
        return $this->state(function () {
            return [
                'state' => SourceState::PUBLISHED,
            ];
        });
    }

    public function pending(): self
    {
        return $this->state(function () {
            return [
                'state' => SourceState::PENDING,
            ];
        });
    }

    public function denied(): self
    {
        return $this->state(function () {
            return [
                'state' => SourceState::DENIED,
            ];
        });
    }
}
