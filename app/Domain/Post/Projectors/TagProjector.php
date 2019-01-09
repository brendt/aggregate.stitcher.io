<?php

namespace App\Domain\Post\Projectors;

use Domain\Post\Events\CreateTagEvent;
use Domain\Post\Events\UpdateTagEvent;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class TagProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreateTagEvent::class => 'createTag',
        UpdateTagEvent::class => 'updateTag',
    ];

    public function createTag(CreateTagEvent $event): void
    {
        $topic = $event->topic_uuid
            ? Topic::whereUuid($event->topic_uuid)->firstOrFail()
            : null;

        Tag::create([
            'topic_id' => $topic ? $topic->id : null,
            'name' => $event->name,
            'color' => $event->color,
            'keywords' => $event->keywords,
        ]);
    }

    public function updateTag(UpdateTagEvent $event): void
    {
        $tag = Tag::whereUuid($event->tag_uuid)->firstOrFail();

        $topic = $event->topic_uuid
            ? Topic::whereUuid($event->topic_uuid)->firstOrFail()
            : null;

        $tag->topic_id = $topic ? $topic->id : null;
        $tag->name = $event->name;
        $tag->color = $event->color;
        $tag->keywords = $event->keywords;

        $tag->save();
    }
}
