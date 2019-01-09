<?php

namespace App\Domain\Post\Projectors;

use Domain\Post\Events\CreateTopicEvent;
use Domain\Post\Events\UpdateTopicEvent;
use Domain\Post\Models\Topic;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class TopicProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreateTopicEvent::class => 'createTopic',
        UpdateTopicEvent::class => 'updateTopic',
    ];

    public function createTopic(CreateTopicEvent $event): void
    {
        Topic::create([
            'name' => $event->name,
        ]);
    }

    public function updateTopic(UpdateTopicEvent $event): void
    {
        $topic = Topic::whereUuid($event->topic_uuid)->firstOrFail();

        $topic->name = $event->name;

        $topic->save();
    }
}
