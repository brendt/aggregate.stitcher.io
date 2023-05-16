<?php

namespace App\Services\PostSharing\Posters;

use App\Http\Controllers\Auth\TwitterOAuthController;
use App\Models\PostShare;
use App\Services\PostSharing\ChannelPoster;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Exception;
use League\OAuth2\Client\Token\AccessToken;
use Smolblog\OAuth2\Client\Provider\Twitter;

final class TwitterPoster implements ChannelPoster
{
    private BirdElephant $twitter;

    public function __construct()
    {
        $this->twitter = new BirdElephant($this->getCredentials());
    }

    public function post(PostShare $postShare): void
    {
        try {
            $tweet = (new Tweet)->text("Test, feel free to ignore");

            $this->twitter->tweets()->tweet($tweet);
        }  catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    private function getCredentials(): array
    {
        return [
            'consumer_key' => config('services.twitter.v2.api_key'),
            'consumer_secret' => config('services.twitter.v2.api_key_secret'),
            'bearer_token' => config('services.twitter.v2.bearer_token'),
            'token_identifier' => config('services.twitter.access_token'),
            'token_secret' => config('services.twitter.access_token_secret'),
        ] + $this->getToken();
    }

    private function getToken(): array
    {
        $provider = new Twitter([
            'clientId'     => config('services.twitter.v2.client_id'),
            'clientSecret' => config('services.twitter.v2.api_key_secret'),
            'redirectUri'  => action(TwitterOAuthController::class),
        ]);

        $token = new AccessToken(json_decode(file_get_contents(storage_path('twitter_oauth')), true));

        if ($token->hasExpired()) {
            $token = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $token->getRefreshToken()
            ]);

            file_put_contents(storage_path('twitter_oauth'), json_encode($token));
        }

        return ['auth_token' => $token->getToken()];
    }

}
