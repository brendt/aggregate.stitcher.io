<?php

namespace Domain\Source\Actions;

use App\Mail\SourceAcceptedMail;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;

final class ActivateSourceAction
{
    /** @var \Illuminate\Mail\Mailer */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(Source $source): void
    {
        $source->is_active = true;

        $source->save();

        $this->notifySourceOwner($source);
    }

    private function notifySourceOwner(Source $source): void
    {
        $admin = User::whereAdmin()->first();

        if ($source->user->is($admin)) {
            return;
        }

        $mail = new SourceAcceptedMail($source);

        $this->mailer->send($mail);
    }
}
