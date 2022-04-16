<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::composer('*', function (View $view) {
            $view->with([
                'pendingPosts' => Post::query()->where('state', PostState::PENDING)->count(),
                'pendingSources' => Source::query()->where('state', SourceState::PENDING)->count(),
            ]);
        });
    }
}
