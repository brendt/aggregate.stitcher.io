<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Source;

final class SourceDuplicationFound
{
    public function __construct(
        public readonly Source $source,
    )
    {
    }
}
