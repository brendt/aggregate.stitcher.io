<?php

namespace Domain\Post\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class CreateTagEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $name;

    /** @var string */
    public $color;

    /** @var string[] */
    public $keywords;

    public function __construct(string $name, string $color, array $keywords)
    {
        parent::__construct([
            'name' => $name,
            'color' => $color,
            'keywords' => $keywords,
        ]);
    }

    public static function new(string $name, string $color, array $keywords): CreateTagEvent
    {
        return new self(
            $name,
            $color,
            $keywords
        );
    }
}
