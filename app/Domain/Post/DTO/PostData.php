<?php

namespace App\Domain\Post\DTO;

use Domain\Post\Decorators\RssEntryDecorator;
use Domain\Post\Models\Post;
use Ramsey\Uuid\Uuid;
use Spatie\DataTransferObject\DataTransferObject;
use Zend\Feed\Reader\Entry\AbstractEntry;

class PostData extends DataTransferObject
{
    /** @var string */
    public $uuid;

    /** @var string */
    public $url;

    /** @var string */
    public $title;

    /** @var \Carbon\Carbon|null */
    public $date_created;

    /** @var string */
    public $teaser;

    public function __construct(array $parameters)
    {
        $parameters['uuid'] = $parameters['uuid'] ?? (string) Uuid::uuid4();

        parent::__construct($parameters);
    }

    public static function create(
        AbstractEntry $entry
    ): PostData {
        $decoratedEntry = new RssEntryDecorator($entry);

        return new self([
            'url' => $decoratedEntry->url(),
            'title' => $decoratedEntry->title(),
            'date_created' => $decoratedEntry->createdAt(),
            'teaser' => '',
        ]);
    }

    public function hasChanges(Post $post): bool
    {
        return $post->title !== $this->title
            || $post->teaser !== $this->teaser;
    }
}
