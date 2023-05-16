<?php

namespace App\Providers;

use App\Console\Commands\SourceDebugCommand;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use App\Models\Tweet;
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

        $this->app->singleton(BirdElephant::class, function () {
            return new BirdElephant([
                'consumer_key' => config('services.twitter.v2.api_key'),
                'consumer_secret' => config('services.twitter.v2.api_key_secret'),
                'bearer_token' => config('services.twitter.v2.bearer_token'),
                'token_identifier' => config('services.twitter.access_token'),
                'token_secret' => config('services.twitter.access_token_secret'),
            ]);
        });
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
