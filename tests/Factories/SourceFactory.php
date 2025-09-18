<?php

namespace Tests\Factories;

use App\Posts\Source;
use App\Posts\SourceState;
use Tests\Factory;
use Tests\IsFactory;

final class SourceFactory implements Factory
{
    use IsFactory;

    private ?string $name = null;
    private ?string $uri = null;
    private ?int $visits = null;
    private ?int $rank = null;
    private ?SourceState $state = null;

    public function make(int $i = 0): Source
    {
        return Source::create(
            name: $this->name ?? "Test Source {$i}",
            uri: $this->uri ?? "https://example.com/rss/{$i}",
            visits: $this->visits ?? 0,
            rank: $this->rank ?? 0,
            state: $this->state ?? SourceState::PENDING,
        );
    }
}