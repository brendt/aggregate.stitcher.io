<?php

namespace Domain\Mute\Events;

use Domain\Mute\Muteable;
use Domain\User\Models\User;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UnmuteEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $user_uuid;

    /** @var string */
    public $muteable_type;

    /** @var string */
    public $muteable_uuid;

    public function __construct(string $user_uuid, string $muteable_type, string $muteable_uuid)
    {
        $this->user_uuid = $user_uuid;
        $this->muteable_type = $muteable_type;
        $this->muteable_uuid = $muteable_uuid;
    }

    public static function make(User $user, Muteable $muteable): UnmuteEvent
    {
        return new self(
            $user->uuid,
            $muteable->getMuteableType(),
            $muteable->getUuid()
        );
    }
}
