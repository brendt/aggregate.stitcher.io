<?php

namespace App\Subscribers;

use Domain\Post\Events\PostChangedEvent;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Support\PageCache\PageCache;

final class PostSubscriber
{
    /** @var \Support\PageCache\PageCache */
    protected $pageCache;

    public function __construct(PageCache $pageCache)
    {
        $this->pageCache = $pageCache;
    }

    public function onPostChange(PostChangedEvent $postChangedEvent): void
    {
        Log::debug("Post changed: {$postChangedEvent->post->uuid}: " . json_encode($postChangedEvent->fields));

        $this->pageCache->flush();
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            PostChangedEvent::class,
            self::class . "@onPostChange"
        );
    }
}
