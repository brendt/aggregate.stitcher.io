<?php

namespace Domain\Source\Actions;

use Domain\Source\Models\Source;
use Exception;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Spatie\QueueableAction\QueueableAction;
use Zend\Feed\Reader\Reader;

final class ValidateSourceAction
{
    use QueueableAction;

    /** @var array|\Closure[] */
    private $formatters;

    public function execute(Source $source): void
    {
        $feedUrls = $this->getPossibleUrls($source->url);

        foreach ($feedUrls as $feedUrl) {
            try {
                Reader::import($feedUrl);

                $source->url = $feedUrl;

                $source->is_validated = true;

                $source->save();

                return;
            } catch (Exception $exception) {
                continue;
            }
        }

        $source->markAsInvalid();
    }

    private function getPossibleUrls(string $url): array
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);

        $host = parse_url($url, PHP_URL_HOST);

        return array_filter([
            $this->urlFromContent($url),
            $url,
            "{$scheme}://{$host}/feed.xml",
            "{$scheme}://{$host}/index.xml",
            "{$scheme}://{$host}/atom.xml",
            "{$scheme}://{$host}/rss.xml",

            "{$scheme}://{$host}/feed",
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

    private function urlFromContent(string $url): ?string
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

        $dom = new Dom();

        $dom->load($html);

        [$link] = $dom->find('head link[type="application/rss+xml"]');

        if (! $link || ! $link->href) {
            return null;
        }

        $href = $link->href;

        if (! Str::startsWith($href, 'http')) {
            $href = $scheme . '://' . preg_replace('/^[\/]+/', '', $href);
        }

        return $href;
    }
}
