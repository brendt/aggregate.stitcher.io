<?php

namespace Domain\Post\DTO;

use Domain\Post\Models\Topic;
use Spatie\DataTransferObject\DataTransferObject;

class TopicData extends DataTransferObject
{
    /** @var string */
    public $name;

    public static function new(
        string $name
    ): TopicData {
        return new self(compact('name'));
    }

    public function hasChanges(Topic $topic): bool
    {
        return $topic->name !== $this->name;
    }
}
