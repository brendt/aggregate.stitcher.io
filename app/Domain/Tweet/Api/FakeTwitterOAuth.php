<?php

namespace Domain\Tweet\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Log;

class FakeTwitterOAuth extends TwitterOAuth
{
    public function __construct()
    {
        // Do nothing
    }

    public function post($path, array $parameters = [], $json = false): void
    {
        Log::debug("Tweet: {$path} " . json_encode($parameters));
    }
}
