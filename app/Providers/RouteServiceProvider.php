<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Post;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));
        });

        Route::bind('post', function (int|string $id) {
            if (Uuid::isValid($id)) {
                return Post::query()->where('uuid', $id)->firstOrFail();
            }

            return Post::findOrFail($id);
        });

        Route::bind('link', function (int|string $id) {
            if (Uuid::isValid($id)) {
                return Link::query()->where('uuid', $id)->firstOrFail();
            }

            return Link::findOrFail($id);
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
