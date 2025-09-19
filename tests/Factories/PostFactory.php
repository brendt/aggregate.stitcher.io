<?php

namespace Tests\Factories;

use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use Tempest\DateTime\DateTime;
use Tests\Factory;
use Tests\IsFactory;

final class PostFactory implements Factory
{
    use IsFactory;

    private ?string $title = null;
    public ?string $uri = null;
    public ?DateTime $createdAt = null;
    public ?DateTime $publicationDate = null;
    public ?Source $source = null;
    public ?PostState $state = null;
    public ?int $visits = null;
    public ?int $rank = null;

    public function withTitle(string $title): self
    {
        $clone = clone $this;

        $clone->title = $title;

        return $clone;
    }

    public function withUri(string $uri): self
    {
        $clone = clone $this;

        $clone->uri = $uri;

        return $clone;
    }

    public function withCreatedAt(DateTime $createdAt): self
    {
        $clone = clone $this;

        $clone->createdAt = $createdAt;

        return $clone;
    }

    public function withSource(Source $source): self
    {
        $clone = clone $this;

        $clone->source = $source;

        return $clone;
    }

    public function withState(PostState $state): self
    {
        $clone = clone $this;

        $clone->state = $state;

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

    public function withPublicationDate(DateTime $publicationDate): self
    {
        $clone = clone $this;

        $clone->publicationDate = $publicationDate;

        return $clone;
    }

    public function make(int $i = 0): Post
    {
        return Post::create(
            title: $this->title ?? "Test Post {$i}",
            uri: $this->uri ?? "https://example.com/posts/{$i}",
            createdAt: $this->createdAt ?? DateTime::now(),
            publicationDate: $this->publicationDate,
            source: $this->source ?? new SourceFactory()->make(),
            state: $this->state ?? PostState::PENDING,
            visits: $this->visits ?? 0,
            rank: $this->rank ?? 0,
        );
    }
}