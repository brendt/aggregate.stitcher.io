<?php

namespace App\Providers;

use App\Console\Commands\SourceDebugCommand;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use App\Models\Tweet;
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
                config('services.twitter.api_key'),
                config('services.twitter.api_secret_key'),
                config('services.twitter.access_token'),
                config('services.twitter.access_token_secret'),
            );
        });
    }

    public function boot()
    {
        \Illuminate\Support\Facades\View::composer('*', function (View $view) {
            $view->with([
                'pendingPosts' => Post::query()
                    ->where('state', PostState::PENDING)
                    ->whereHas('source', function (Builder $query) {
                        $query->where('state', SourceState::PUBLISHED);
                    })
                    ->count(),
                'pendingSources' => Source::query()
                    ->where('state', SourceState::PENDING)
                    ->count(),
                'pendingTweets' => Tweet::query()
                    ->pendingToday()
                    ->count(),
            ]);
        });
    }
}
