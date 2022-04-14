<?php

declare(strict_types=1);

namespace App\Models;

enum SourceState: string
{
    case PENDING = 'pending';
    case PUBLISHING = 'publishing';
    case PUBLISHED = 'published';
    case DENIED = 'denied';
    case INVALID = 'invalid';
    case DUPLICATE = 'duplicate';
}
