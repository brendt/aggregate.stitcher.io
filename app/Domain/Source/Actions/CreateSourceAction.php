<?php

namespace Domain\Source\Actions;

use App\Mail\SourceCreatedMail;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;

final class CreateSourceAction
{
    /** @var \Illuminate\Mail\Mailer */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(User $user, SourceData $sourceData)
    {
        $source = Source::create([
            'user_id' => $user->id,
            'url' => $sourceData->url,
            'is_active' => $sourceData->is_active,
        ]);

        $this->notifyAboutNewSource($source);
    }

    private function notifyAboutNewSource(Source $source): void
    {
        $admin = User::whereAdmin()->first();

        if (! $admin) {
            return;
        }

        if ($source->user->is($admin)) {
            return;
        }

        $mail = new SourceCreatedMail($source, $admin);

        $this->mailer->send($mail);
    }
}
