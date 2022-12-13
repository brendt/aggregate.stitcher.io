<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Source;
use Throwable;

final readonly class SourceFeedUrlTried
{
    public function __construct(
        public Source $source,
        public string $feedUrl,
        public Throwable $exception,
    )
    {
    }
}
