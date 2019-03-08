<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $cacheKey = $this->determineCacheKey($request);

        try {
            $payload = Cache::tags(['page_cache'])->get($cacheKey);

            if (! $payload) {
                $payload = $this->pageCache->serialize($next($request));

                Cache::tags(['page_cache'])->put($cacheKey, $payload, 5);
            }

            return $this->pageCache->unserialize($payload);
        } catch (Exception $exception) {
            return $next($request);
        }
    }

    private function determineCacheKey(Request $request): string
    {
        $key = $request->getUri();

        $user = current_user();

        if ($user) {
            $key .= $user->id;
        }

        return $key;
    }
}
