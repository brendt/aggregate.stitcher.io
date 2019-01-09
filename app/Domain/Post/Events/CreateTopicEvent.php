<?php

namespace Domain\Post\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateTopicEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        parent::__construct([
            'name' => $name,
        ]);
    }

    public static function new(string $name): CreateTopicEvent
    {
        return new self(
            $name
        );
    }
}
