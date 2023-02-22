<?php

namespace App\Http\Controllers;

use App\Actions\ParseRssFeed;
use Illuminate\Support\Facades\Cache;

final class LatestMailController
{
    public function __invoke(ParseRssFeed $parseRssFeed)
    {
        /** @var \App\Data\RssEntry[] $rss */
        $rss = Cache::remember(
            key: 'latest-mail',
            ttl: now()->addDay(),
            callback: fn () => $parseRssFeed(file_get_contents('https://mail.stitcher.io/feed/81fa83d0-4a0b-4eff-b897-f6ce51dfb7f0')),
        );

        $latestEntry = $rss[0];

        $url = $latestEntry->payload['link']['@attributes']['href'] ?? $latestEntry->url;

        return redirect($url);
    }
}
