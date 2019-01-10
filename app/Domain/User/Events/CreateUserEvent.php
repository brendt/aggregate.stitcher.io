<?php

namespace Domain\User\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateUserEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $email;

    /** @var string */
    public $password_hash;

    public function __construct(string $email, string $password_hash)
    {
        parent::__construct(compact('email', 'password_hash'));
    }
}
