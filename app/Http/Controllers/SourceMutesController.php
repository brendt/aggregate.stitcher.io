<?php

namespace App\Http\Controllers;

use App\Domain\Mute\Events\MuteEvent;
use App\Domain\Mute\Events\UnmuteEvent;
use Domain\Source\Models\Source;
use Domain\User\Models\User;

class SourceMutesController
{
    public function store(User $user, Source $source)
    {
        event(MuteEvent::make($user, $source));

        return redirect()->back();
    }

    public function delete(User $user, Source $source)
    {
        event(UnmuteEvent::make($user, $source));

        return redirect()->back();
    }
}
