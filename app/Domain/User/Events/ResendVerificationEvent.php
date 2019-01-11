<?php

namespace Domain\User\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class ResendVerificationEvent extends DataTransferObject implements ShouldBeStored, SendsVerificationEvent
{
    /** @var string */
    public $user_uuid;

    public function __construct(string $user_uuid)
    {
        parent::__construct(compact('user_uuid'));
    }

    public function getUserUuid(): string
    {
        return $this->user_uuid;
    }
}
