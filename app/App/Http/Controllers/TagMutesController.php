<?php

namespace App\Http\Controllers;

use Domain\Mute\Actions\MuteAction;
use Domain\Mute\Actions\UnmuteAction;
use Domain\Post\Models\Tag;
use Domain\User\Models\User;

class TagMutesController
{
    public function store(
        User $user,
        Tag $tag,
        MuteAction $muteAction
    ) {
        $muteAction($user, $tag);

        return redirect()->back();
    }

    public function delete(
        User $user,
        Tag $tag,
        UnmuteAction $unmuteAction
    ) {
        $unmuteAction($user, $tag);

        return redirect()->back();
    }
}
