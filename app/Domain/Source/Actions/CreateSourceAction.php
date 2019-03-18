<?php

namespace Domain\Source\Actions;

use App\Mail\SourceCreatedMail;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;

final class CreateSourceAction
{
    /** @var \Domain\Source\Actions\ResolveTopicsAction */
    private $resolveTopicsAction;

    /** @var \Domain\Source\Actions\ValidateSourceAction */
    private $validateSourceAction;

    /** @var \Illuminate\Mail\Mailer */
    private $mailer;

    public function __construct(
        ResolveTopicsAction $resolveTopicsAction,
        ValidateSourceAction $validateSourceAction,
        Mailer $mailer
    ) {
        $this->resolveTopicsAction = $resolveTopicsAction;
        $this->validateSourceAction = $validateSourceAction;
        $this->mailer = $mailer;
    }

    public function __invoke(?User $user, SourceData $sourceData): Source
    {
        $source = Source::create([
            'user_id' => $user ? $user->id : null,
            'url' => $sourceData->url,
            'twitter_handle' => $sourceData->twitter_handle,
            'is_active' => $sourceData->is_active,
        ]);

        $this->resolveTopicsAction->execute($source, $sourceData);

        $this->validateSourceAction
            ->onQueue()
            ->execute($source);

        $this->notifyAboutNewSource($source);

        return $source;
    }

    private function notifyAboutNewSource(Source $source): void
    {
        $admin = User::whereAdmin()->first();

        if (! $admin) {
            return;
        }

        if ($source->user && $source->user->is($admin)) {
            return;
        }

        $mail = new SourceCreatedMail($source, $admin);

        $this->mailer->send($mail);
    }
}
