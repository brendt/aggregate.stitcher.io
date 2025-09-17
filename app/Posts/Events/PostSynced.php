<?php

namespace App\Posts\Events;

final readonly class PostSynced
{
    public function __construct(
        public string $uri,
    ) {}
}