<?php

namespace App\Posts;

use Tempest\Cache\Cache;
use Tempest\DateTime\DateTime;
use Tempest\Http\Response;
use Tempest\Http\Responses\Ok;
use Tempest\Router\Get;
use Tempest\Router\Stateless;

final class RssController
{
    #[Stateless, Get('/rss')]
    public function __invoke(Cache $cache): Response
    {
        $xml = $cache->resolve(
            key: 'rss',
            callback: fn () => $this->renderRssFeed(
                Post::published()
                    ->orderBy('publicationDate DESC')
                    ->limit(100)
                    ->all(),
            ),
            expiration: DateTime::now()->plusHours(1),
        );

        return new Ok($xml)
            ->addHeader('Content-Type', 'application/xml;charset=UTF-8');
    }

    private function renderRssFeed(array $posts): string
    {
        ob_start();

        include __DIR__ . '/rss.view.php';

        return trim(ob_get_clean());
    }
}