<?php

namespace App\Providers;

use App\Console\Commands\SourceDebugCommand;
use App\Http\Controllers\Auth\RedditOAuthRedirectController;
use App\Http\Controllers\Auth\TwitterOAuthRedirectController;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use App\Models\Tweet;
use App\Services\OAuth\RedditHttpClient;
use App\Services\OAuth\TwitterHttpClient;
use App\Services\PostSharing\Posters\HackerNewsPoster;
use Coderjerk\BirdElephant\BirdElephant;
use DG\Twitter\Twitter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SourceDebugCommand::class, fn () => new SourceDebugCommand());

        $this->app->singleton(Twitter::class, function () {
            return new Twitter(
                consumerKey: config('services.twitter.api_key'),
                consumerSecret: config('services.twitter.api_secret_key'),
                accessToken: config('services.twitter.access_token'),
                accessTokenSecret: config('services.twitter.access_token_secret'),
            );
        });

        $this->app->singleton(RedditHttpClient::class, fn () => new RedditHttpClient(
            clientId: config('services.reddit.client_id'),
            clientSecret: config('services.reddit.client_secret'),
            redirectUrl: action(RedditOAuthRedirectController::class),
        ));

        $this->app->singleton(TwitterHttpClient::class, fn () => new TwitterHttpClient(
            oauth: new \Smolblog\OAuth2\Client\Provider\Twitter([
                'clientId' => config('services.twitter.v2.client_id'),
                'clientSecret' => config('services.twitter.v2.client_secret'),
                'redirectUri' => action(TwitterOAuthRedirectController::class),
            ]),
            redirectUrl: action(TwitterOAuthRedirectController::class),
        ));
    }

    public function boot()
    {
        $pendingPosts = Post::query()
            ->where('state', PostState::PENDING)
            ->whereHas('source', function (Builder $query) {
                $query->where('state', SourceState::PUBLISHED);
            })
            ->count();

        $pendingSources = Source::query()
            ->where('state', SourceState::PENDING)
            ->count();

        $pendingTweets = Tweet::query()
            ->pendingToday()
            ->count();

        \Illuminate\Support\Facades\View::composer('*', function (View $view) use ($pendingTweets, $pendingSources, $pendingPosts) {
            $view->with([
                'pendingPosts' => $pendingPosts,
                'pendingSources' => $pendingSources,
                'pendingTweets' => $pendingTweets,
            ]);
        });
    }
}
