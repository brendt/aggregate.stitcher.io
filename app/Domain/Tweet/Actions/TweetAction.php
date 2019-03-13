<?php

namespace Domain\Tweet\Actions;

use App\Console\Jobs\TweetJob;
use Domain\Tweet\Api\TwitterGateway;
use Domain\Tweet\Models\Tweet;
use Domain\Tweet\Tweetable;

final class TweetAction
{
    /** @var \Domain\Tweet\Api\TwitterGateway */
    private $gateway;

    public function __construct(TwitterGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function execute(Tweetable $tweetable): void
    {
        $tweet = Tweet::createForTweetable($tweetable);

        if (config('queue.default') === 'redis') {
            dispatch(new TweetJob($tweet));
        } else {
            $this->gateway->tweet($tweet);
        }
    }
}
