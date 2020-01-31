<?php

namespace App\Providers;

use App\Feed\Controllers\PostsController;
use App\User\Middleware\RedirectToUserFeedMiddleware;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Support\Middleware\PageCacheMiddleware;

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
        Route::bind('post', fn (string $uuid): Post => Post::whereUuid($uuid)->firstOrFail());

        Route::bind('topic', fn (string $slug): Topic => Topic::whereSlug($slug)->firstOrFail());

        Route::bind('tag', fn (string $slug): Tag => Tag::whereSlug($slug)->firstOrFail());

        Route::bind('sourceByWebsite', fn (string $website): Source => Source::whereWebsite($website)->firstOrFail());
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware([
            'web',
            PageCacheMiddleware::class,
        ])
            ->group(base_path('routes/web_cached.php'));

        Route::middleware([
            'web',
            RedirectToUserFeedMiddleware::class,
//            PageCacheMiddleware::class,
        ])->group(function (): void {
            Route::get('/', [PostsController::class, 'index']);
        });

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
