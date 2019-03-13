<?php

namespace Domain\Tweet\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Log;

final class TwitterGateway
{
    /** @var \Abraham\TwitterOAuth\TwitterOAuth */
    private $client;

    public function __construct(TwitterOAuth $client)
    {
        $this->client = $client;
    }

    public function tweet(string $status)
    {
        Log::debug("Tweeted: {$status}");

        return $this->client->post('statuses/update', [
            'status' => $status,
        ]);
    }
}
