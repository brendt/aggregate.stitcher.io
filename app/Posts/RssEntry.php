<?php

namespace App\Posts;

use Tempest\DateTime\DateTime;

final readonly class RssEntry
{
    public function __construct(
        public string $uri,
        public string $title,
        public ?DateTime $createdAt,
        public array $payload,
    ) {}
}
