<?php

namespace App\Suggestions\Events;

final readonly class FeedUrisResolved
{
    public function __construct(
        public array $uris,
    ) {}
}