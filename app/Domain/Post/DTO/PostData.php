<?php

namespace Domain\Post\DTO;

use Domain\Post\Decorators\RssEntryDecorator;
use Domain\Post\Models\Post;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Zend\Feed\Reader\Entry\AbstractEntry;

class PostData extends DataTransferObject
{
    /** @var string */
    public $url;

    /** @var string */
    public $title;

    /** @var \Carbon\Carbon|null */
    public $date_created;

    /** @var string */
    public $teaser;

    /** @var int[] */
    public $tag_ids = [];

    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }

    /**
     * @param \Zend\Feed\Reader\Entry\AbstractEntry|\Zend\Feed\Reader\Entry\EntryInterface $entry
     * @param \Illuminate\Support\Collection|\Domain\Post\Models\Tag[] $tags
     *
     * @return \Domain\Post\DTO\PostData
     */
    public static function create(
        AbstractEntry $entry,
        Collection $tags
    ): PostData {
        $decoratedEntry = new RssEntryDecorator($entry, $tags);

        return new self([
            'url' => $decoratedEntry->url(),
            'title' => $decoratedEntry->title(),
            'date_created' => $decoratedEntry->createdAt(),
            'teaser' => '',
            'tag_ids' => $decoratedEntry->tags()->toArray(),
        ]);
    }

    public function fillable(): array
    {
        return $this->only(
            'url',
            'title',
            'date_created',
            'teaser'
        )->toArray();
    }

    public function hasChanges(Post $post): bool
    {
        return $post->title !== $this->title
            || $post->teaser !== $this->teaser
            || $post->hasDifferentTags($this->tag_ids)
            || $post->date_created->format('Y-m-d H:i') !== $this->date_created->format('Y-m-d H:i');
    }
}
