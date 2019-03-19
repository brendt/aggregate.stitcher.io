<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Post;
use Domain\User\Events\ChangeForUserEvent;
use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class VoteRemovedEvent extends DataTransferObject implements ChangeForUserEvent
{
    /** @var \Domain\User\Models\User */
    public $user;

    /** @var \Domain\Post\Models\Post */
    public $post;

    public static function new(User $user, Post $post): VoteRemovedEvent
    {
        return new self([
            'user' => $user,
            'post' => $post,
        ]);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
