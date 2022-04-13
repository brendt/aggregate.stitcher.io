<?php

declare(strict_types=1);

namespace App\Models;

enum PostState: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case STARRED = 'starred';
    case DENIED = 'denied';
}
