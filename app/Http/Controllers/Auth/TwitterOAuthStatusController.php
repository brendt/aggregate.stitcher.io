<?php

namespace App\Http\Controllers\Auth;

use App\Services\OAuth\TwitterHttpClient;

final class TwitterOAuthStatusController
{
    public function __invoke(TwitterHttpClient $client)
    {
        return 'ok';
    }
}
