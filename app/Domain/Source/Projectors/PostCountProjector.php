<?php

namespace Domain\Source\Projectors;

use Domain\Post\Events\CreatePostEvent;
use Domain\Source\Models\Source;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class PostCountProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreatePostEvent::class => 'updatePostCount',
    ];

    public function updatePostCount(CreatePostEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->first();

        if (! $source) {
            return;
        }

        $source->post_count = $source->posts->count();

        $source->save();
    }
}
