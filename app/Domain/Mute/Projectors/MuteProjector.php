<?php

namespace App\Domain\Mute\Projectors;

use App\Domain\Mute\Events\MuteEvent;
use App\Domain\Mute\Events\UnmuteEvent;
use Domain\Mute\Models\Mute;
use Domain\User\Models\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class MuteProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        MuteEvent::class => 'mute',
        UnmuteEvent::class => 'unmute',
    ];

    public function mute(MuteEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        Mute::create([
            'user_id' => $user->id,
            'muteable_type' => $event->muteable_type,
            'muteable_uuid' => $event->muteable_uuid,
        ]);
    }

    public function unmute(UnmuteEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        Mute::query()
            ->whereUser($user)
            ->whereMuteableType($event->muteable_type)
            ->whereMuteableUuid($event->muteable_uuid)
            ->delete();
    }
}
