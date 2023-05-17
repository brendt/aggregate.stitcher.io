<?php

namespace App\Http\Controllers\Auth;

use App\Services\OAuth\RedditHttpClient;

final class RedditOAuthController
{
    public function __invoke(RedditHttpClient $client)
    {
        return $client->authorize();
    }
}
