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
    /** @var \Domain\Post\Models\Tag[]|\Illuminate\Database\Eloquent\Collection */
    private $tags;

    public function __construct()
    {
        $this->tags = Tag::all();
    }

    public function __invoke(Source $source)
    {
        $feed = Reader::import($source->url);

        foreach ($feed as $entry) {
            $postData = PostData::create($entry, $this->tags);

            /** @var \Domain\Post\Models\Post $post */
            $post = $source->posts()->where('url', $postData->url)->first();

            if (! $post) {
                event(CreatePostEvent::create($source, $postData));

                continue;
            }

            if ($postData->hasChanges($post)) {
                event(UpdatePostEvent::create($post, $postData));

                continue;
            }
        }
    }
}
