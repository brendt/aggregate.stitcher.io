<?php

namespace App\Domain\Source\Events;

use Domain\Source\Models\Source;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class DeleteSourceEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $source_uuid;

    public function __construct(string $source_uuid)
    {
        $this->source_uuid = $source_uuid;
    }

    public static function create(Source $source): DeleteSourceEvent
    {
        return new self($source->uuid);
    }
}
