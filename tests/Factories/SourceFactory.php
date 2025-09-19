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

    public function withName(string $name): self
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    public function withUri(string $uri): self
    {
        $clone = clone $this;

        $clone->uri = $uri;

        return $clone;
    }

    public function withVisits(int $visits): self
    {
        $clone = clone $this;

        $clone->visits = $visits;

        return $clone;
    }

    public function withRank(int $rank): self
    {
        $clone = clone $this;

        $clone->rank = $rank;

        return $clone;
    }

    public function withState(SourceState $state): self
    {
        $clone = clone $this;

        $clone->state = $state;

        return $clone;
    }

    public function make(int $i = 0): Source
    {
        return Source::create(
            name: $this->name ?? "Test Source {$i}",
            uri: $this->uri ?? "https://example.com/rss/{$i}",
            visits: $this->visits ?? 0,
            rank: $this->rank ?? 0,
            state: $this->state ?? SourceState::PUBLISHED,
        );
    }
}