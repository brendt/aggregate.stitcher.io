<?php

namespace Support\PageCache;

use Closure;
use Domain\User\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Log;

final class PageCache
{
    /** @var string */
    private $key;

    /** @var \Illuminate\Cache\TaggedCache|Cache */
    private $cache;

    /** @var int */
    private $defaultCacheTime = 10;

    public function __construct(Request $request)
    {
        $this->key = $this->makeCacheKey($request, current_user());

        try {
            $this->cache = Cache::tags(['page_cache'])->setDefaultCacheTime($this->defaultCacheTime);
        } catch (Exception $exception) {
            $this->cache = Cache::setDefaultCacheTime($this->defaultCacheTime);
        }
    }

    public function resolve(Closure $next, Request $request): Response
    {
        $payload = $this->cache->get($this->key);

        if (! $payload) {
            $payload = $this->serialize($next($request));

            $this->cache->put($this->key, $payload, 60 * $this->defaultCacheTime);

            Log::debug("Cache miss on {$this->key}");
        } else {
            Log::debug("Cache hit on {$this->key}");
        }

        return $this->unserialize($payload);
    }

    public function flush(): void
    {
        $this->cache->flush();

        Log::debug("Cache flushed");
    }

    public function serialize(Response $response): string
    {
        return $response->content();
    }

    public function unserialize(string $payload): Response
    {
        return response($payload, Response::HTTP_OK, [
            'X-Page-Cached' => 'true'
        ]);
    }

    private function makeCacheKey(Request $request, ?User $user): string
    {
        $key = $request->getUri();

        if ($user) {
            $key .= '::' . $user->id;
        }

        return $key;
    }
}
