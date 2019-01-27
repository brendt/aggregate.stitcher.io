<?php

namespace Domain\Mute\Actions;

use Domain\Mute\Models\Mute;
use Domain\Mute\Muteable;
use Domain\User\Models\User;

final class MuteAction
{
    public function __invoke(User $user, Muteable $muteable): void
    {
        Mute::create([
            'user_id' => $user->id,
            'muteable_type' => $muteable->getMuteableType(),
            'muteable_uuid' => $muteable->getUuid(),
        ]);
    }
}
