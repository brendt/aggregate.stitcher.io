<?php

namespace Domain\Mute\Actions;

use Domain\Mute\Events\MuteChangedEvent;
use Domain\Mute\Models\Mute;
use Domain\Mute\Muteable;
use Domain\User\Models\User;

final class UnmuteAction
{
    public function __invoke(User $user, Muteable $muteable): void
    {
        Mute::query()
            ->whereUser($user)
            ->whereMuteableType($muteable->getMuteableType())
            ->whereMuteableUuid($muteable->getUuid())
            ->delete();

        event(MuteChangedEvent::create($user));
    }
}
