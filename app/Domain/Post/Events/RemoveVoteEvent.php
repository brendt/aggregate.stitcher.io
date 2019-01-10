<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class RemoveVoteEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $post_uuid;

    /** @var string */
    public $user_uuid;

    public function __construct(string $post_uuid, string $user_uuid)
    {
        parent::__construct([
            'post_uuid' => $post_uuid,
            'user_uuid' => $user_uuid,
        ]);
    }

    public static function create(Post $post, User $user): RemoveVoteEvent
    {
        return new self($post->uuid, $user->uuid);
    }
}
