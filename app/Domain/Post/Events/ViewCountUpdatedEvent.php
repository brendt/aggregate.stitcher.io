<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;

final class ViewCountUpdatedEvent extends DataTransferObject
{
    /** @var \Domain\Post\Models\Post */
    public $post;

    /** @var int */
    public $viewCount;

    /** @var int */
    public $weeklyViewCount;

    public static function create(
        Post $post,
        int $viewCount,
        int $weeklyViewCount
    ): ViewCountUpdatedEvent {
        return new self([
            'post' => $post,
            'viewCount' => $viewCount,
            'weeklyViewCount' => $weeklyViewCount,
        ]);
    }
}
