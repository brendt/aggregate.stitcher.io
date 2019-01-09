<?php

namespace App\Domain\Post\Actions;

use Domain\Post\Events\CreateTopicEvent;
use Domain\Post\Events\UpdateTopicEvent;
use Domain\Post\Models\Topic;

class SyncTopicAction
{
    public function __invoke(string $name): void
    {
        $existingTopic = Topic::whereName($name)->first();

        if ($existingTopic) {
            $event = UpdateTopicEvent::new(
                $existingTopic,
                $name
            );

            if ($event->hasChanges($existingTopic)) {
                event($event);
            }

            return;
        }

        event(CreateTopicEvent::new(
            $name
        ));
    }
}
