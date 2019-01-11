<?php

namespace Domain\User\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class VerifyUserEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $user_uuid;

    /** @var string */
    public $verification_token;

    public function __construct(string $user_uuid, string $verification_token)
    {
        parent::__construct(compact('user_uuid', 'verification_token'));
    }
}
