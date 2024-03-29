<?php

declare(strict_types=1);

namespace App\Models;

enum TweetState: string
{
    case PENDING = 'pending';
    case SAVED = 'saved';
    case PUBLISHED = 'published';
    case DENIED = 'denied';
    case REJECTED = 'rejected';
}
