<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;

abstract class PostEvent extends DataTransferObject
{
    /** @var \Domain\Post\Models\Post */
    public $post;

    /** @var array */
    public $fields;

    public static function create(Post $post, array $fields)
    {
        return new static([
            'post' => $post,
            'fields' => $fields,
        ]);
    }
}
