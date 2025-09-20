<?php

namespace App\Factories;

use App\Suggestions\Suggestion;
use App\Support\Factory;
use App\Support\IsFactory;
use Symfony\Component\Uid\UuidV4;
use Tempest\DateTime\DateTime;

final class SuggestionFactory implements Factory
{
    use IsFactory;

    private ?string $uri = null;
    private ?DateTime $suggestedAt = null;
    private ?string $suggestedBy = null;

    public function withUri(string $uri): self
    {
        $clone = clone $this;

        $clone->uri = $uri;

        return $clone;
    }

    public function withSuggestedAt(DateTime $suggestedAt): self
    {
        $clone = clone $this;

        $clone->suggestedAt = $suggestedAt;

        return $clone;
    }

    public function withSuggestedBy(string $suggestedBy): self
    {
        $clone = clone $this;

        $clone->suggestedBy = $suggestedBy;

        return $clone;
    }

    public function make(int $i = 0): object
    {
        return Suggestion::create(
            uri: $this->uri ?? 'https://example.com/posts/' . $i,
            suggestedAt: $this->suggestedAt ?? DateTime::now(),
            suggestedBy: $this->suggestedBy ?? new UuidV4()->toString(),
        );
    }
}