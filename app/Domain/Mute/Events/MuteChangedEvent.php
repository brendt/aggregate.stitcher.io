<?php

namespace Domain\Mute\Events;

use Domain\Mute\Models\Mute;
use Domain\User\Events\ChangeForUserEvent;
use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class MuteChangedEvent extends DataTransferObject implements ChangeForUserEvent
{
    /** @var \Domain\User\Models\User */
    public $user;

    /** @var \Domain\Mute\Models\Mute|null */
    public $mute;

    public static function create(User $user, ?Mute $mute = null): MuteChangedEvent
    {
        return new self([
            'user' => $user,
            'mute' => $mute,
        ]);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
