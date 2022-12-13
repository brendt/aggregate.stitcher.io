<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Source;

final readonly class SourceFeedUrlFound
{
    public function __construct(
        public Source $source,
        public string $feedUrl,
    )
    {
    }
}
