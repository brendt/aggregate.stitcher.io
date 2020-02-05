<?php

namespace App\Admin\Middleware;

use Closure;
use Domain\Analytics\PreloadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

final class OpcacheStatusMiddleware
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

        return $next($request);
    }
}
