<?php

namespace Domain\Post\Events;

use Domain\Post\Models\Tag;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UpdateTagEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $tag_uuid;

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
        array $keywords
    ) {
        parent::__construct([
            'tag_uuid' => $tag_uuid,
            'name' => $name,
            'color' => $color,
            'keywords' => $keywords,
        ]);
    }

    public static function new(
        Tag $tag,
        string $name,
        string $color,
        array $keywords
    ): UpdateTagEvent {
        return new self(
            $tag->uuid,
            $name,
            $color,
            $keywords
        );
    }

    public function hasChanges(Tag $tag): bool
    {
        return $tag->name !== $this->name
            || $tag->color !== $this->color
            || $tag->keywords !== $this->keywords;
    }
}
