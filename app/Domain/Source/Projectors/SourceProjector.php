<?php

namespace Domain\Source\Projectors;

use Domain\Post\Events\CreatePostEvent;
use Domain\Source\Events\ActivateSourceEvent;
use Domain\Source\Events\CreateSourceEvent;
use Domain\Source\Events\DeleteSourceEvent;
use Domain\Source\Events\SourceCreatedEvent;
use Domain\Source\Events\UpdateSourceEvent;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class SourceProjector implements Projector
{
    use ProjectsEvents;

    public $handlesEvents = [
        CreateSourceEvent::class => 'createSource',
        UpdateSourceEvent::class => 'updateSource',
        DeleteSourceEvent::class => 'deleteSource',
        ActivateSourceEvent::class => 'activateSource',
    ];

    public function createSource(CreateSourceEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        $source = Source::create([
            'user_id' => $user->id,
            'url' => $event->url,
            'is_active' => $event->is_active,
        ]);

        event(SourceCreatedEvent::fromSource($source));
    }

    public function updateSource(UpdateSourceEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        $source->fill($event->except('source_uuid')->toArray());

        $source->save();
    }

    public function deleteSource(DeleteSourceEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        $source->delete();
    }

    public function activateSource(ActivateSourceEvent $event): void
    {
        $source = Source::whereUuid($event->source_uuid)->firstOrFail();

        $source->is_active = true;

        $source->save();
    }
}
