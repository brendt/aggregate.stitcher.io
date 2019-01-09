<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UpdateTagEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $tag_uuid;

    /** @var string|null */
    public $topic_uuid;

    /** @var string */
    public $name;

    /** @var string */
    public $color;

    /** @var string[] */
    public $keywords;

    public function __construct(
        string $tag_uuid,
        string $name,
        string $color,
        array $keywords,
        ?string $topic_uuid = null
    ) {
        parent::__construct([
            'tag_uuid' => $tag_uuid,
            'topic_uuid' => $topic_uuid,
            'name' => $name,
            'color' => $color,
            'keywords' => $keywords,
        ]);
    }

    public static function new(
        Tag $tag,
        string $name,
        string $color,
        array $keywords,
        ?Topic $topic = null
    ): UpdateTagEvent {
        return new self(
            $tag->uuid,
            $name,
            $color,
            $keywords,
            $topic ? $topic->uuid : null
        );
    }

    public function hasChanges(Tag $tag): bool
    {
        return
            optional($tag->topic)->uuid !== $this->topic_uuid
            || $tag->name !== $this->name
            || $tag->color !== $this->color
            || $tag->keywords !== $this->keywords;
    }
}
