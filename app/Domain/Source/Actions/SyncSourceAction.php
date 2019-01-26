<?php

namespace Domain\Source\Actions;

use Domain\Post\DTO\PostData;
use Domain\Post\Events\CreatePostEvent;
use Domain\Post\Events\UpdatePostEvent;
use Domain\Post\Models\Tag;
use Domain\Source\Models\Source;
use Illuminate\Support\Collection;
use Support\Rss\Reader;
use Zend\Feed\Reader\Entry\EntryInterface;

class SyncSourceAction
{
    /** @var \Support\Rss\Reader */
    protected $reader;

    /** @var string|null */
    private $filterUrl = null;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function setFilterUrl(string $filterUrl): SyncSourceAction
    {
        $this->filterUrl = $filterUrl;

        return $this;
    }

    public function __invoke(Source $source)
    {
        /** @var \Domain\Post\Models\Tag[]|\Illuminate\Database\Eloquent\Collection */
        $tags = Tag::all();

        $feed = $this->reader->import($source->url);

        /** @var \Zend\Feed\Reader\Entry\EntryInterface $entry */
        foreach ($feed as $entry) {
            if ($this->filterUrl && $this->filterUrl !== $entry->getLink()) {
                continue;
            }

            $this->syncPost($source, $entry, $tags);
        }
    }

    private function syncPost(
        Source $source,
        EntryInterface $entry,
        Collection $tags
    ): void {
        $postData = PostData::create($entry, $tags);

        if ($source->hasOtherPostOnSameDay($postData->url, $postData->date_created)) {
            return;
        }

        /** @var \Domain\Post\Models\Post $post */
        $post = $source->posts->where('url', $postData->url)->first();

        if (! $post) {
            event(CreatePostEvent::new($source, $postData));

            return;
        }

        if ($postData->hasChanges($post)) {
            event(UpdatePostEvent::new($post, $postData));

            return;
        }
    }
}
