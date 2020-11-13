<?php

namespace Domain\Spam\Actions;

use Domain\Mute\Events\MuteChangedEvent;
use Domain\Mute\Models\Mute;
use Domain\Mute\Muteable;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;
use Domain\Spam\Models\Spam;
use Domain\User\Models\User;


final class SourceReportAction
{
    public function __invoke(User $user, Source $source): void
    {
        $spam = Spam::create([
                                 'user_id' => $user->id,
                                 'source_id' => $source->id
                             ]);

        event(MuteChangedEvent::create($user, $spam));
    }
}