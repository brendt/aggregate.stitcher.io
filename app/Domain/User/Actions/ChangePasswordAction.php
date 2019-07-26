<?php
namespace Domain\User\Actions;

use Domain\User\Models\User;

class ChangePasswordAction
{
    public function __invoke(User $user, string $newPassword): void
    {
        $user->password = $newPassword;
        $user->save();
    }
}
