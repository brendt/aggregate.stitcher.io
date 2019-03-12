<?php

namespace App\Http\Controllers;

use Domain\Mute\Actions\MuteAction;
use Domain\Mute\Actions\UnmuteAction;
use Domain\Source\Models\Source;
use Domain\User\Models\User;

final class SourceMutesController
{
    public function store(
        User $user,
        Source $source,
        MuteAction $muteAction
    ) {
        $muteAction($user, $source);

        return redirect()->back();
    }

    public function delete(
        User $user,
        Source $source,
        UnmuteAction $unmuteAction
    ) {
        $unmuteAction($user, $source);

        return redirect()->back();
    }
}
