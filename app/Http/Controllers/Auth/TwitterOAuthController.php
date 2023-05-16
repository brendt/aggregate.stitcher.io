<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Smolblog\OAuth2\Client\Provider\Twitter;

final class TwitterOAuthController
{
    public function __invoke(Request $request)
    {
        $provider = new Twitter([
            'clientId' => config('services.twitter.v2.client_id'),
            'clientSecret' => config('services.twitter.v2.client_secret'),
            'redirectUri' => action(TwitterOAuthController::class),
        ]);

        $code = $request->get('code');

        if (! $code) {
            Session::remove('oauth2state');
            Session::remove('oauth2verifier');

            $options = [
                'scope' => [
                    'tweet.read',
                    'tweet.write',
                ],
            ];

            $authUrl = $provider->getAuthorizationUrl($options);
            Session::put('oauth2state', $provider->getState());
            Session::put('oauth2verifier', $provider->getPkceVerifier());

            return redirect()->to($authUrl);
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $code,
            'code_verifier' => Session::get('oauth2verifier'),
        ]);

        Session::put('oauth-2-access-token', $token);

        file_put_contents(storage_path('twitter_oauth'), json_encode($token));

        return json_encode($token);
    }
}
