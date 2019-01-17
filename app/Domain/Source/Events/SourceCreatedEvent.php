<?php

namespace Domain\Source\Events;

use Domain\Source\Models\Source;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class SourceCreatedEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $source_uuid;

    public function __construct(string $source_uuid)
    {
        parent::__construct([
            'source_uuid' => $source_uuid,
        ]);
    }

    public static function fromSource(Source $source): SourceCreatedEvent
    {
        return new self($source->uuid);
    }
}
