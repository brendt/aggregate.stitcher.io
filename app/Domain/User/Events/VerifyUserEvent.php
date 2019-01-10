<?php

namespace Domain\User\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class VerifyUserEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $user_uuid;

    public function __construct(string $user_uuid)
    {
        parent::__construct(compact('user_uuid'));
    }
}
