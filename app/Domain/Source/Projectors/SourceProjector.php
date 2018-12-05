<?php

namespace App\Domain\Source\Projectors;

use App\Domain\Source\Events\CreateSourceEvent;
use App\Domain\Source\Events\DeleteSourceEvent;
use App\Domain\Source\Events\UpdateSourceEvent;
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
    ];

    public function createSource(CreateSourceEvent $event): void
    {
        $user = User::whereUuid($event->user_uuid)->firstOrFail();

        Source::create([
            'user_id' => $user->id,
            'url' => $event->url,
            'is_active' => $event->is_active,
        ]);
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
}
