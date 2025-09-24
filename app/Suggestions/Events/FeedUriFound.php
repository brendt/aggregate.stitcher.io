<?php

namespace App\Suggestions\Events;

final readonly class FeedUriFound
{
    public function __construct(
        public string $uri,
    ) {}
}