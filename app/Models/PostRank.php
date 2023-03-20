<?php

namespace App\Models;

final readonly class PostRank
{
    public function __construct(
        public int $position,
        public int $total,
    ) {}

    public function __toString(): string
    {
        return "{$this->position}&thinsp;/&thinsp;{$this->total}";
    }
}
