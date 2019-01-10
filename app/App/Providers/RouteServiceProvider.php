<?php

namespace App\Providers;

use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        $this->mapBindings();

        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapBindings()
    {
        Route::bind('post', function (string $uuid): Post {
            return Post::whereUuid($uuid)->firstOrFail();
        });

        Route::bind('topic', function (string $slug): Topic {
            return Topic::whereSlug($slug)->firstOrFail();
        });

        Route::bind('tag', function (string $slug): Tag {
            return Tag::whereSlug($slug)->firstOrFail();
        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
