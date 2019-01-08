<?php

namespace App\Http\Controllers;

use App\Domain\Mute\Events\MuteEvent;
use App\Domain\Mute\Events\UnmuteEvent;
use Domain\Post\Models\Tag;
use Domain\User\Models\User;

class TagMutesController
{
    public function store(User $user, Tag $tag)
    {
        event(MuteEvent::make($user, $tag));

        return redirect()->action([PostsController::class, 'index']);
    }

    public function delete(User $user, Tag $tag)
    {
        event(UnmuteEvent::make($user, $tag));

        return redirect()->back();
    }
}
