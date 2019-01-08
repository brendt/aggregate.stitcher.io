<?php

namespace App\Domain\Post\Actions;

use Domain\Post\Events\CreateTagEvent;
use Domain\Post\Events\UpdateTagEvent;
use Domain\Post\Models\Tag;

class SyncTagAction
{
    public function __invoke(string $name, string $color, array $keywords): void
    {
        $existingTag = Tag::whereName($name)->first();

        if ($existingTag) {
            $event = UpdateTagEvent::new(
                $existingTag,
                $name,
                $color,
                $keywords
            );

            if ($event->hasChanges($existingTag)) {
                event($event);
            }

            return;
        }

        event(CreateTagEvent::new(
            $name,
            $color,
            $keywords
        ));
    }
}
