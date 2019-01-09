<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateTagEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string|null */
    public $topic_uuid;

    /** @var string */
    public $name;

    /** @var string */
    public $color;

    /** @var string[] */
    public $keywords;

    public function __construct(
        string $name,
        string $color,
        array $keywords,
        ?string $topic_uuid = null
    ) {
        parent::__construct([
            'topic_uuid' => $topic_uuid,
            'name' => $name,
            'color' => $color,
            'keywords' => $keywords,
        ]);
    }

    public static function new(
        string $name,
        string $color,
        array $keywords,
        ?Topic $topic = null
    ): CreateTagEvent {
        return new self(
            $name,
            $color,
            $keywords,
            $topic ? $topic->uuid : null
        );
    }
}
