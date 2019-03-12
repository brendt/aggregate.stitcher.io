<?php

namespace Domain\Source\Events;

use Spatie\DataTransferObject\DataTransferObject;

final class SourceDeletedEvent extends DataTransferObject
{
    public static function create(): SourceDeletedEvent
    {
        return new self([]);
    }
}
