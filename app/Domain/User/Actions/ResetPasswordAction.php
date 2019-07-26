<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;
use Illuminate\Support\Str;

final class ResetPasswordAction
{
    public function __invoke(User $user, string $passwordHash): void
    {
        $user->password = $passwordHash;

        $user->setRememberToken(Str::random(60));

        $user->save();
    }
}
