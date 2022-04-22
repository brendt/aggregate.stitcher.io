<?php

namespace App\Providers;

use App\Console\Commands\SourceDebugCommand;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SourceDebugCommand::class, fn () => new SourceDebugCommand());
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
            ]);
        });
    }
}
