<?php

namespace App\Services\OAuth;

use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Token\AccessToken;
use Smolblog\OAuth2\Client\Provider\Twitter as TwitterOauth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class TwitterHttpClient
{
    public function __construct(
        private TwitterOauth $oauth,
        private string $redirectUrl,
    ) {}

    public function authorize(): HttpResponse
    {
        Session::remove('oauth2state');
        Session::remove('oauth2verifier');

        $options = [
            'scope' => [
                'tweet.read',
                'tweet.write',
                'tweet.moderate.write',
                'users.read',
                'follows.read',
                'follows.write',
                'offline.access',
                'space.read',
                'mute.read',
                'mute.write',
                'like.read',
                'like.write',
                'list.read',
                'list.write',
                'block.read',
                'block.write',
                'bookmark.read',
                'bookmark.write',
            ]
        ];

        $authUrl = $this->oauth->getAuthorizationUrl($options);

        Session::put('oauth2state', $this->oauth->getState());
        Session::put('oauth2verifier', $this->oauth->getPkceVerifier());

        return redirect()->to($authUrl);
    }

    public function retrieveNewToken(string $code, string $state): AccessToken
    {
        $stateFromSession = Session::get('oauth2state');

        abort_unless($stateFromSession === $state, 403);

        $token = $this->oauth->getAccessToken('authorization_code', [
            'code' => $code,
            'code_verifier' => Session::get('oauth2verifier'),
        ]);

        return $this->storeToken($token);
    }

    public function tweet(string $tweet): object
    {
        $tweet = (new Tweet)->text($tweet);

        return $this->client()->tweets()->tweet($tweet);
    }

    public function me(): object
    {
        return $this->client()->user('brendt_gd');
    }

    private function client(): BirdElephant
    {
        return new BirdElephant([
            'consumer_key' => config('services.twitter.v2.api_key'),
            'consumer_secret' => config('services.twitter.v2.api_key_secret'),
            'bearer_token' => config('services.twitter.v2.bearer_token'),
            'token_identifier' => config('services.twitter.access_token'),
            'token_secret' => config('services.twitter.access_token_secret'),
            'auth_token' => $this->resolveToken()->getToken(),
        ]);
    }

    private function resolveToken(): AccessToken
    {
        $token = $this->tokenFromFile();

        if (! $token->hasExpired()) {
            return $token;
        }

        $token = $this->oauth->getAccessToken('refresh_token', [
            'refresh_token' => $token->getRefreshToken()
        ]);

        return $this->storeToken($token);
    }

    private function storeToken(AccessToken $token): AccessToken
    {
        file_put_contents(storage_path('twitter_oauth'), json_encode($token));

        return $this->tokenFromFile();
    }

    public function tokenFromFile(): AccessToken
    {
        return new AccessToken(
            json_decode(
                json: file_get_contents(storage_path('twitter_oauth')),
                associative: true
            )
        );
    }
}
