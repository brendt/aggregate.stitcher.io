<?php

namespace App\Admin\Middleware;

use Closure;
use Domain\Analytics\PreloadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

final class AdminStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $opcacheStatus = opcache_get_status();

        if (isset($opcacheStatus['preload_statistics'])) {
            ViewFacade::composer(
                '*',
                fn (View $view) => $view->with('preloadStatus', PreloadStatus::make(opcache_get_status()))
            );
        }

        if (config('app.page_cache')) {
            ViewFacade::composer(
                '*',
                fn (View $view) => $view->with('pageCacheEnabled', true)
            );
        }

        ViewFacade::composer(
            '*',
            fn (View $view) => $view->with('currentCommit', trim(shell_exec('git rev-parse HEAD')))
        );

        return $next($request);
    }
}
