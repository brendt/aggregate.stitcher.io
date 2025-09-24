<?php

namespace App\Suggestions\Events;

final readonly class FeedUriFetchFailed
{
    public function __construct(
        public string $uri,
    ) {}
}