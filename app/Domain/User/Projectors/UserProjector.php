<?php

namespace Domain\User\Projectors;

use Domain\User\Events\VerifyUserEvent;
use Domain\User\Events\CreateUserEvent;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class UserProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreateUserEvent::class => 'createUser',
        VerifyUserEvent::class => 'verifyUser',
    ];

    public function createUser(CreateUserEvent $event): void
    {
        User::create([
            'name' => $event->email,
            'email' => $event->email,
            'password' => $event->password_hash,
        ]);
    }

    public function verifyUser(VerifyUserEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        $user->verified = true;

        $user->save();
    }
}
