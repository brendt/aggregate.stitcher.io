<?php

namespace App\Suggestions\Events;

use Throwable;

final readonly class FeedUrisFetchFailed
{
    public function __construct(
        public Throwable $exception,
    ) {}
}