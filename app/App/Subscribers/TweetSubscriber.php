<?php

namespace App\Subscribers;

use Domain\Post\Events\ViewCountUpdatedEvent;
use Domain\Tweet\Actions\TweetAction;
use Illuminate\Events\Dispatcher;

final class TweetSubscriber
{
    private const VIEW_THRESHOLD = 5;

    /** @var \Domain\Tweet\Actions\TweetAction */
    private $tweetAction;

    public function __construct(TweetAction $tweetAction)
    {
        $this->tweetAction = $tweetAction;
    }

    public function attemptTweet(ViewCountUpdatedEvent $event): void
    {
        if ($event->viewCount !== self::VIEW_THRESHOLD) {
            return;
        }

        if ($event->post->hasBeenTweeted()) {
            return;
        }

        $this->tweetAction->execute($event->post);
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            [
                ViewCountUpdatedEvent::class,
            ],
            self::class . "@attemptTweet"
        );
    }
}
