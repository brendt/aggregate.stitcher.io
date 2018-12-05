<?php

namespace Domain\Source\Actions;

use App\Domain\Post\DTO\PostData;
use Domain\Post\Events\CreatePostEvent;
use Domain\Post\Events\UpdatePostEvent;
use Domain\Source\Models\Source;
use Zend\Feed\Reader\Reader;

class SyncSourceAction
{
    public function __invoke(Source $source)
    {
        $feed = Reader::import($source->url);

        foreach ($feed as $entry) {
            $postData = PostData::create($entry);

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
