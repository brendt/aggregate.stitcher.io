<?php

namespace App\Domain\Post\Projectors;

use Domain\Post\Events\CreateTagEvent;
use Domain\Post\Events\UpdateTagEvent;
use Domain\Post\Models\Tag;
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
        Tag::create([
            'name' => $event->name,
            'color' => $event->color,
            'keywords' => $event->keywords,
        ]);
    }

    public function updateTag(UpdateTagEvent $event): void
    {
        $tag = Tag::whereUuid($event->tag_uuid)->firstOrFail();

        $tag->name = $event->name;
        $tag->color = $event->color;
        $tag->keywords = $event->keywords;

        $tag->save();
    }
}
