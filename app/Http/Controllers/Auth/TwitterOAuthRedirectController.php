<?php

namespace App\Http\Controllers\Auth;

use App\Services\OAuth\TwitterHttpClient;
use Illuminate\Http\Request;

final class TwitterOAuthRedirectController
{
    public function __invoke(TwitterHttpClient $client, Request $request)
    {
        abort_if($request->get('error'), 403);

        $client->retrieveNewToken(
            $request->get('code'),
            $request->get('state')
        );

        return 'done';
    }
}
