<?php

namespace Domain\Source\Actions;

use App\Domain\Post\DTO\PostData;
use Domain\Post\Events\CreatePostEvent;
use Domain\Post\Events\UpdatePostEvent;
use Domain\Post\Models\Tag;
use Domain\Source\Models\Source;
use Zend\Feed\Reader\Reader;

class SyncSourceAction
{
    /** @var string|null */
    private $filterUrl = null;

    public function setFilterUrl(string $filterUrl): SyncSourceAction
    {
        $this->filterUrl = $filterUrl;

        return $this;
    }

    public function __invoke(Source $source)
    {
        /** @var \Domain\Post\Models\Tag[]|\Illuminate\Database\Eloquent\Collection */
        $tags = Tag::all();

        $feed = Reader::import($source->url);

        /** @var \Zend\Feed\Reader\Entry\EntryInterface $entry */
        foreach ($feed as $entry) {
            if ($this->filterUrl && $this->filterUrl !== $entry->getLink()) {
                continue;
            }

            $postData = PostData::create($entry, $tags);

            /** @var \Domain\Post\Models\Post $post */
            $post = $source->posts()->where('url', $postData->url)->first();

            if (! $post) {
                event(CreatePostEvent::new($source, $postData));

                continue;
            }

            if ($postData->hasChanges($post)) {
                event(UpdatePostEvent::new($post, $postData));

                continue;
            }
        }
    }
}
