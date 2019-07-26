<?php

namespace Domain\Tweet\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use Domain\Tweet\Models\Tweet;
use Illuminate\Support\Facades\Log;

final class TwitterGateway
{
    /** @var \Abraham\TwitterOAuth\TwitterOAuth */
    private $client;

    public function __construct(TwitterOAuth $client)
    {
        $this->client = $client;
    }

    public function tweet(Tweet $tweet)
    {
        Log::debug("Tweeted: {$tweet->status}");

        $tweet->markAsSent();

        return $this->client->post('statuses/update', [
            'status' => $tweet->status,
        ]);
    }
}
