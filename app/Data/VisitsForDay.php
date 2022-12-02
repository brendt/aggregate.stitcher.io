<?php

namespace App\Data;

use Carbon\Carbon;

final class VisitsForDay
{
    public function __construct(
        public readonly int $visits,
        public readonly Carbon $day,
    ) {}

    public function rebase(int $base, int $max): self
    {
        return new self(
            visits: $this->visits * ($base / $max),
            day: $this->day,
        );
    }
}
