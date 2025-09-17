<?php

namespace App\Posts\Events;

final class SourceSynced
{
    public function __construct(
        public string $uri,
    ) {}
}