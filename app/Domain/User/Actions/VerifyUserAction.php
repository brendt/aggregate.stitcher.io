<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;

final class VerifyUserAction
{
    public function __invoke(User $user): void
    {
        $user->is_verified = true;

        $user->save();
    }
}
