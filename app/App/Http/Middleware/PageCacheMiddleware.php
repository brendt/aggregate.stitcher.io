<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Support\PageCache\PageCache;

final class PageCacheMiddleware
{
    /** @var \Support\PageCache\PageCache */
    protected $pageCache;

    public function __construct(PageCache $pageCache)
    {
        $this->pageCache = $pageCache;
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            return $this->pageCache->resolve($next, $request);
        } catch (Exception $exception) {
            Log::debug("Cache error {$exception->getMessage()}");

            return $next($request);
        }
    }
}
