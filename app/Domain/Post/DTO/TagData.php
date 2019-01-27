<?php

namespace Domain\Post\DTO;

use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;

class TagData extends DataTransferObject
{
    /** @var \Domain\Post\Models\Topic|null */
    public $topic;

    /** @var string */
    public $name;

    /** @var string */
    public $color;

    /** @var string[] */
    public $keywords;

    public static function new(
        string $name,
        string $color,
        array $keywords,
        ?Topic $topic = null
    ): TagData {
        return new self(compact('name', 'color', 'keywords', 'topic'));
    }

    public function hasChanges(Tag $tag): bool
    {
        return
            optional($tag->topic)->uuid !== $this->topic->uuid
            || $tag->name !== $this->name
            || $tag->color !== $this->color
            || $tag->keywords !== $this->keywords;
    }
}
