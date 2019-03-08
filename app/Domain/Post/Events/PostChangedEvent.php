<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;

class PostChangedEvent extends DataTransferObject
{
    /** @var \Domain\Post\Models\Post */
    public $post;

    public static function create(Post $post)
    {
        return new self([
            'post' => $post,
        ]);
    }
}
