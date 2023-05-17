<?php

namespace App\Http\Controllers\Auth;

use App\Services\OAuth\RedditHttpClient;
use Illuminate\Http\Request;

final class RedditOAuthRedirectController
{
    public function __invoke(Request $request, RedditHttpClient $client)
    {
        abort_if($request->get('error'), 403);

        $client->retrieveNewToken(
            code: $request->get('code'),
            state: $request->get('state')
        );

        return 'done';
    }
}
