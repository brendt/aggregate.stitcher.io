<?php

namespace App\Subscribers;

use Domain\Post\Events\PostChangedEvent;
use Illuminate\Events\Dispatcher;
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
