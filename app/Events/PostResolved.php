<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Post;

final readonly class PostResolved
{
    public function __construct(
        public Post $post,
        public array $payload,
    ) {
    }
}
