<?php

namespace Domain\Source\Reactors;

use App\Mail\SourceAcceptedMail;
use App\Mail\SourceCreatedMail;
use Domain\Source\Events\ActivateSourceEvent;
use Domain\Source\Events\CreateSourceEvent;
use Domain\Source\Events\SourceCreatedEvent;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class SourceReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        ActivateSourceEvent::class => 'sendVerification',
        SourceCreatedEvent::class => 'notifyAboutNewSource',
    ];

    /** @var \Illuminate\Mail\Mailer */
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendVerification(ActivateSourceEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        $admin = User::whereAdmin()->first();

        if ($source->user->is($admin)) {
            return;
        }

        $mail = new SourceAcceptedMail($source);

        $this->mailer->send($mail);
    }

    public function notifyAboutNewSource(SourceCreatedEvent $event): void
    {
        $admin = User::whereAdmin()->first();

        if (! $admin) {
            return;
        }

        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        if ($source->user->is($admin)) {
            return;
        }

        $mail = new SourceCreatedMail($source, $admin);

        $this->mailer->send($mail);
    }
}
