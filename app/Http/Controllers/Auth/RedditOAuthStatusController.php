<?php

namespace App\Http\Controllers\Auth;

use App\Services\OAuth\RedditHttpClient;

final class RedditOAuthStatusController
{
    public function __invoke(RedditHttpClient $client)
    {
        return 'ok';
    }
}
