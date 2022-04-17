<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Source;
use Throwable;

final class SourceFeedUrlTried
{
    public function __construct(
        public readonly Source $source,
        public readonly string $feedUrl,
        public readonly Throwable $exception,
    )
    {
    }
}
