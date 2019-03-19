<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Vote;
use Domain\User\Events\ChangeForUserEvent;
use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class VoteCreatedEvent extends DataTransferObject implements ChangeForUserEvent
{
    /** @var \Domain\Post\Models\Vote */
    public $vote;

    public static function new(Vote $vote): VoteCreatedEvent
    {
        return new self([
            'vote' => $vote,
        ]);
    }

    public function getUser(): User
    {
        return $this->vote->user;
    }
}
