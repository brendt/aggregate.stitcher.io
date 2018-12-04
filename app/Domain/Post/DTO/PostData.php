<?php

namespace Domain\Post\DTO;

use Domain\Post\Decorators\RssEntryDecorator;
use Spatie\DataTransferObject\DataTransferObject;
use Zend\Feed\Reader\Entry\AbstractEntry;

class PostData extends DataTransferObject
{
    /** @var string */
    public $url;

    /** @var string */
    public $title;

    /** @var \Carbon\Carbon */
    public $date_created;

    /** @var string */
    public $teaser;

    public static function create(AbstractEntry $entry): PostData
    {
        $decoratedEntry = new RssEntryDecorator($entry);

        return new self([
            'url' => $decoratedEntry->url(),
            'title' => $decoratedEntry->title(),
            'date_created' => $decoratedEntry->createdAt(),
            'teaser' => '',
        ]);
    }
}
