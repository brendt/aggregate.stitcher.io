<?php

namespace App\Services\OAuth;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class RedditHttpClient
{
    private const SESSION_STATE = 'reddit_state';

    public function __construct(
        private string $clientId,
        private string $clientSecret,
        private string $redirectUrl,
    ) {}

    public function authorize(): HttpResponse
    {
        $url = 'https://www.reddit.com/api/v1/authorize';

        $state = Str::random(40);

        $queryParams = collect([
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'state' => $state,
            'redirect_uri' => $this->redirectUrl,
            'duration' => 'permanent',
            'scope' => 'identity edit flair history modconfig modflair modlog modposts modwiki mysubreddits privatemessages read report save submit subscribe vote wikiedit wikiread',
        ]);

        Session::put(self::SESSION_STATE, $state);

        $url .= '?' . $queryParams
                ->map(fn(string $value, $key) => "{$key}=" . urlencode($value))
                ->implode('&');

        return redirect()->to($url);
    }

    public function retrieveNewToken(string $code, string $state): AccessToken
    {
        $stateFromSession = Session::get(self::SESSION_STATE);

        abort_unless($stateFromSession === $state, 403);

        $authToken = base64_encode("{$this->clientId}:{$this->clientSecret}");

        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => "Basic {$authToken}",
            ])
            ->post(
                'https://www.reddit.com/api/v1/access_token',
                [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $this->redirectUrl,
                ]
            );

        return $this->storeToken(json_decode($response->body(), true));
    }

    public function submitLink(string $subReddit, string $url, string $title): Response
    {
        if (app()->environment('local')) {
            $subReddit = 'brendt_testing';
        }

        return $this->httpClient()->asForm()->post(
            url: 'https://oauth.reddit.com/api/submit',
            data: [
                'api_type' => 'json',
                'sr' => $subReddit,
                'kind' => 'link',
            ] + [
                'url' => $url,
                'title' => $title,
            ],
        );
    }

    private function httpClient(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => "Bearer {$this->resolveToken()->getToken()}",
        ]);
    }

    private function resolveToken(): AccessToken
    {
        $token = $this->tokenFromFile();

        $authToken = base64_encode("{$this->clientId}:{$this->clientSecret}");

        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => "Basic {$authToken}",
            ])
            ->post(
                'https://www.reddit.com/api/v1/access_token',
                [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token->getRefreshToken(),
                ]
            );

        return $this->storeToken(json_decode($response->body(), true));
    }

    private function storeToken(array $token): AccessToken
    {
        file_put_contents(storage_path('reddit_oauth'), json_encode($token));

        return $this->tokenFromFile();
    }

    /**
     * @return AccessToken
     */
    public function tokenFromFile(): AccessToken
    {
        $token = new AccessToken(
            json_decode(
                json: file_get_contents(storage_path('reddit_oauth')),
                associative: true
            )
        );
        return $token;
    }
}
