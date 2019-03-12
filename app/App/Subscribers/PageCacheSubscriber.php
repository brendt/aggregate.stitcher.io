<?php

namespace App\Subscribers;

use Domain\Mute\Events\MuteChangedEvent;
use Domain\Post\Events\PostChangedEvent;
use Domain\Source\Events\SourceDeletedEvent;
use Domain\User\Events\ChangeForUserEvent;
use Illuminate\Events\Dispatcher;
use Support\PageCache\PageCache;

final class PageCacheSubscriber
{
    public function flushCache(): void
    {
        PageCache::flush();
    }

    public function flushUserCache(ChangeForUserEvent $event): void
    {
        PageCache::flush($event->getUser());
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            PostChangedEvent::class,
            self::class . "@flushCache"
        );

        $dispatcher->listen(
            SourceDeletedEvent::class,
            self::class . "@flushCache"
        );

        $dispatcher->listen(
            MuteChangedEvent::class,
            self::class . "@flushUserCache"
        );
    }
}
