<?php

namespace App\Suggestions;

use App\Suggestions\Events\FeedUriFetchEmpty;
use App\Suggestions\Events\FeedUriFetchFailed;
use App\Suggestions\Events\FeedUriFound;
use App\Suggestions\Events\FeedUrisFetchFailed;
use App\Suggestions\Events\FeedUrisResolved;
use Dom\HTMLDocument;
use Feed;
use Throwable;
use function Tempest\event;
use function Tempest\Support\str;

final readonly class FindSuggestionFeedUri
{
    public function __invoke(string $searchUri): ?string
    {
        try {
            $uris = $this->getPossibleUris($searchUri);
        } catch (Throwable $exception) {
            event(new FeedUrisFetchFailed($exception));

            return null;
        }

        event(new FeedUrisResolved($uris));

        foreach ($uris as $uri) {
            try {
                $input = @file_get_contents($uri);
                $xml = simplexml_load_string($input, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                json_decode($json, true, flags: JSON_THROW_ON_ERROR);
            } catch (Throwable) {
                event(new FeedUriFetchFailed($uri));

                continue;
            }

            event(new FeedUriFound($uri));

            return $uri;
        }

        return null;
    }

    private function getPossibleUris(string $uri): array
    {
        $scheme = parse_url($uri, PHP_URL_SCHEME);

        $host = parse_url($uri, PHP_URL_HOST);

        $uriFromContent = $this->uriFromContent($uri);

        if (str_starts_with($uriFromContent, '/')) {
            $uriFromContent = "{$scheme}://{$host}{$uriFromContent}";
        }

        return array_filter([
            $uriFromContent,
            $uri,
            "{$scheme}://{$host}/feed.xml",
            "{$scheme}://{$host}/index.xml",
            "{$scheme}://{$host}/atom.xml",
            "{$scheme}://{$host}/rss.xml",

            "{$scheme}://{$host}/feed",
            "{$scheme}://{$host}/feed.atom",
            "{$scheme}://{$host}/index",
            "{$scheme}://{$host}/atom",
            "{$scheme}://{$host}/rss",

            "{$scheme}://{$host}/blog/feed.xml",
            "{$scheme}://{$host}/blog/index.xml",
            "{$scheme}://{$host}/blog/atom.xml",
            "{$scheme}://{$host}/blog/rss.xml",

            "{$scheme}://{$host}/blog/feed",
            "{$scheme}://{$host}/blog/index",
            "{$scheme}://{$host}/blog/atom",
            "{$scheme}://{$host}/blog/rss",
            "{$scheme}://{$host}/blog/feed.atom",

            "{$scheme}://feed.{$host}",
            "{$scheme}://rss.{$host}",
        ]);
    }

    private function uriFromContent(string $url): ?string
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $html = @file_get_contents($url);

        if (! $html) {
            $host = parse_url($url, PHP_URL_HOST);

            $html = @file_get_contents("{$scheme}://{$host}");
        }

        if (! $html) {
            return null;
        }

        preg_match(
            pattern: '/<link rel="alternate" type="application\/rss\+xml" [\w\=\"|\s]+ href=\"([^"]+)/',
            subject: $html,
            matches: $matches,
        );

        if ($url = $matches[1] ?? null) {
            return $url;
        }

        $dom = HTMLDocument::createFromString($html);

        [$link] = $dom->querySelector('head link[type="application/rss+xml"]');

        if (! $link || ! $link->href) {
            return null;
        }

        $href = $link->href;

        if (! str($href)->startsWith('http')) {
            $href = $scheme . '://' . preg_replace('/^\/+/', '', $href);
        }

        return $href;
    }
}