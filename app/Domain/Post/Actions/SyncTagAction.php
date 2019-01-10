<?php

namespace Domain\Post\Actions;

use Domain\Post\Events\CreateTagEvent;
use Domain\Post\Events\UpdateTagEvent;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;

class SyncTagAction
{
    public function __invoke(
        string $name,
        string $color,
        array $keywords,
        ?Topic $topic = null
    ): void {
        $existingTag = Tag::whereName($name)->first();

        if ($existingTag) {
            $event = UpdateTagEvent::new(
                $existingTag,
                $name,
                $color,
                $keywords,
                $topic
            );

            if ($event->hasChanges($existingTag)) {
                event($event);
            }

            return;
        }

        event(CreateTagEvent::new(
            $name,
            $color,
            $keywords,
            $topic
        ));
    }
}
