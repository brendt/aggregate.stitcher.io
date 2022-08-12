<?php declare(strict_types=1);

namespace App\Models;

enum PostType: string
{
    case BLOG = 'blog';
    case TWEET = 'tweet';
}
