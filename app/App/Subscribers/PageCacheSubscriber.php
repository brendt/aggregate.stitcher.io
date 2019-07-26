<?php

namespace App\Subscribers;

use Domain\Mute\Events\MuteChangedEvent;
use Domain\Post\Events\PostCreatedEvent;
use Domain\Post\Events\PostUpdatedEvent;
use Domain\Post\Events\VoteCreatedEvent;
use Domain\Post\Events\VoteRemovedEvent;
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
            [
                PostCreatedEvent::class,
                PostUpdatedEvent::class,
                SourceDeletedEvent::class,
            ],
            self::class . "@flushCache"
        );

        $dispatcher->listen(
            [
                MuteChangedEvent::class,
                VoteCreatedEvent::class,
                VoteRemovedEvent::class,
            ],
            self::class . "@flushUserCache"
        );
    }
}
