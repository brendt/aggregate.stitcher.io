<?php

namespace Domain\Tweet\Actions;

use Domain\Tweet\Api\TwitterGateway;
use Domain\Tweet\Models\Tweet;
use Domain\Tweet\Tweetable;
use Spatie\QueueableAction\QueueableAction;

final class TweetAction
{
    use QueueableAction;

    /** @var \Domain\Tweet\Api\TwitterGateway */
    private $gateway;

    public function __construct(TwitterGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function execute(Tweetable $tweetable): void
    {
        $tweet = Tweet::createForTweetable($tweetable);

        $this->gateway->tweet($tweet);
    }
}
