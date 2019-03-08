<?php

namespace App\Providers;

use App\Http\Middleware\PageCacheMiddleware;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = '';

    public function boot(): void
    {
        $this->mapBindings();

        parent::boot();
    }

    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapBindings(): void
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

        Route::bind('sourceByWebsite', function (string $website): Source {
            return Source::whereWebsite($website)->firstOrFail();
        });
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware([
            'web',
            PageCacheMiddleware::class,
        ])
            ->group(base_path('routes/web_cached.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
