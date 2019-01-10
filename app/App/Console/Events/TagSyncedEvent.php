<?php

namespace App\Console\Events;

use Spatie\DataTransferObject\DataTransferObject;

class TagSyncedEvent extends DataTransferObject
{
    /** @var string */
    public $tagName;

    public function __construct(string $tagName)
    {
        parent::__construct(compact('tagName'));
    }
}
