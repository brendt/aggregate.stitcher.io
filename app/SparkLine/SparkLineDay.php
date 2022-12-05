<?php

namespace App\SparkLine;

use Carbon\Carbon;

final class SparkLineDay
{
    public function __construct(
        public readonly int $count,
        public readonly Carbon $day,
    ) {}

    public function rebase(int $base, int $max): self
    {
        return new self(
            count: $this->count * ($base / $max),
            day: $this->day,
        );
    }
}
