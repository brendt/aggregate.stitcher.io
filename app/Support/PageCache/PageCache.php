<?php

namespace Support\PageCache;

use Illuminate\Http\Response;

class PageCache
{
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
}
