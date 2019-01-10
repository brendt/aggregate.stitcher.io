<?php

namespace App\Console\Events;

use Spatie\DataTransferObject\DataTransferObject;

class TopicSyncedEvent extends DataTransferObject
{
    /** @var string */
    public $topicName;

    public function __construct(string $topicName)
    {
        parent::__construct(compact('topicName'));
    }
}
