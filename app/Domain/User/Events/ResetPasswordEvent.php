<?php

namespace Domain\User\Events;

use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class ResetPasswordEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $user_uuid;

    /** @var string */
    public $password_hash;

    public function __construct(string $user_uuid, string $password_hash)
    {
        parent::__construct(compact('user_uuid', 'password_hash'));
    }

    public static function create(User $user, string $password_hash): ResetPasswordEvent
    {
        return new self(
            $user->uuid,
            $password_hash
        );
    }
}
