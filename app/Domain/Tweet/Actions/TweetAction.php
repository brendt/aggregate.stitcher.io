<?php

namespace Domain\Tweet\Actions;

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
        $status = $tweetable->getTwitterStatus();

        Tweet::createForTweetable($tweetable, $status);

        $this->gateway->tweet($status);
    }
}
