<?php

namespace App\Models;

final readonly class PostRank
{
    public function __construct(
        public int $position,
        public int $total,
    ) {}

    public function getSaturation(): int
    {
        $percentage = (1 - $this->position / $this->total) * 100 + 1;

        // Steps by 10% is accurate enough
        return min([100, (ceil($percentage / 10)) * 10]);
    }

    public function __toString(): string
    {
        return "{$this->position}&thinsp;/&thinsp;{$this->total}";
    }
}
