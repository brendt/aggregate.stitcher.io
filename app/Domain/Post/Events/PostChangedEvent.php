<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;

class PostChangedEvent extends DataTransferObject
{
    /** @var \Domain\Post\Models\Post */
    public $post;

    /** @var array */
    public $fields;

    public static function create(Post $post, array $fields)
    {
        return new self([
            'post' => $post,
            'fields' => $fields,
        ]);
    }
}
