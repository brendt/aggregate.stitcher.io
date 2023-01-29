<?php

namespace App\Data;

use Carbon\Carbon;

final readonly class RssEntry
{
    public function __construct(
        public string $url,
        public string $title,
        public ?Carbon $createdAt,
        public array $payload,
    ) {}
}
