<?php

namespace Domain\Source\Reactors;

use App\Mail\SourceAcceptedMail;
use Domain\Source\Events\ActivateSourceEvent;
use Domain\Source\Models\Source;
use Illuminate\Mail\Mailer;
use Spatie\EventProjector\EventHandlers\EventHandler;
use Spatie\EventProjector\EventHandlers\HandlesEvents;

class SourceReactor implements EventHandler
{
    use HandlesEvents;

    protected $handlesEvents = [
        ActivateSourceEvent::class => 'sendVerification',
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

        $mail = new SourceAcceptedMail($source);

        $this->mailer->send($mail);
    }
}
