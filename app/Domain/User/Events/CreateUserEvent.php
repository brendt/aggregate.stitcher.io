<?php

namespace Domain\User\Events;

use Ramsey\Uuid\Uuid;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateUserEvent extends DataTransferObject implements ShouldBeStored, SendsVerificationEvent
{
    /** @var string */
    public $user_uuid;

    /** @var string */
    public $email;

    /** @var string */
    public $password_hash;

    public function __construct(string $user_uuid, string $email, string $password_hash)
    {
        parent::__construct(compact('user_uuid', 'email', 'password_hash'));
    }

    public static function create(string $email, string $password_hash): CreateUserEvent
    {
        return new self(
            (string) Uuid::uuid4(),
            $email,
            $password_hash
        );
    }

    public function getUserUuid(): string
    {
        return $this->user_uuid;
    }
}
