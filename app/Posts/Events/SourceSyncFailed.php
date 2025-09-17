<?php

namespace App\Posts\Events;

final class SourceSyncFailed
{
    public function __construct(
        public string $uri,
    ) {}
}