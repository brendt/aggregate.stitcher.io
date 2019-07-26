<?php

namespace Domain\Source\Actions;

use Domain\Mute\Models\Mute;
use Domain\Source\Events\SourceDeletedEvent;
use Domain\Source\Models\Source;

final class DeleteSourceAction
{
    public function __invoke(Source $source): void
    {
        $source->mutes->each(function (Mute $mute) {
            $mute->delete();
        });

        $source->delete();

        event(SourceDeletedEvent::create());
    }
}
