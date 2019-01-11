<?php

namespace Domain\User\Reactors;

use App\Mail\VerifyUserMail;
use Domain\User\Events\CreateUserEvent;
use Domain\User\Events\ResendVerificationEvent;
use Domain\User\Events\SendsVerificationEvent;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class UserReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        CreateUserEvent::class => 'sendVerification',
        ResendVerificationEvent::class => 'sendVerification',
    ];

    /** @var \Illuminate\Mail\Mailer */
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendVerification(SendsVerificationEvent $event): void
    {
        $user = User::whereUuid($event->getUserUuid())->firstOrFail();

        $mail = new VerifyUserMail($user);

        $this->mailer->send($mail);
    }
}
