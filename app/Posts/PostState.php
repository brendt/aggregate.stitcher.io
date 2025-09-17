<?php

namespace App\Posts;

enum PostState: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case STARRED = 'starred';
    case DENIED = 'denied';
}
