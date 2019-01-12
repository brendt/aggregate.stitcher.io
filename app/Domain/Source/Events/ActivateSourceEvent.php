<?php

namespace Domain\Source\Events;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class ActivateSourceEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $source_uuid;

    public function __construct(string $source_uuid)
    {
        parent::__construct([
            'source_uuid' => $source_uuid,
        ]);
    }
}
