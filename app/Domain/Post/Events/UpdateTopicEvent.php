<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UpdateTopicEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $topic_uuid;

    /** @var string */
    public $name;

    public function __construct(
        string $topic_uuid,
        string $name
    ) {
        parent::__construct([
            'topic_uuid' => $topic_uuid,
            'name' => $name,
        ]);
    }

    public static function new(
        Topic $topic,
        string $name
    ): UpdateTopicEvent {
        return new self(
            $topic->uuid,
            $name
        );
    }

    public function hasChanges(Topic $topic): bool
    {
        return $topic->name !== $this->name;
    }
}
