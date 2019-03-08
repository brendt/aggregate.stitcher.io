<?php

namespace Domain\Source\Actions;

use Domain\Source\Models\Source;
use Exception;
use Spatie\QueueableAction\QueueableAction;
use Zend\Feed\Reader\Reader;

final class ValidateSourceAction
{
    use QueueableAction;

    /** @var array|\Closure[] */
    private $formatters;

    public function execute(Source $source): void
    {
        $host = parse_url($source->url, PHP_URL_HOST);

        $feedUrls = $this->getFormats($host);

        $feedUrls[] = $source->url;

        $scheme = parse_url($source->url, PHP_URL_SCHEME);

        foreach ($feedUrls as $feedUrl) {
            $feedUrl = "{$scheme}://{$feedUrl}";

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
    }

    private function getFormats(string $host): array
    {
        return [
            "{$host}/feed.xml",
            "{$host}/index.xml",
            "{$host}/atom.xml",
            "{$host}/rss.xml",

            "{$host}/feed",
            "{$host}/index",
            "{$host}/atom",
            "{$host}/rss",

            "{$host}/blog/feed.xml",
            "{$host}/blog/index.xml",
            "{$host}/blog/atom.xml",
            "{$host}/blog/rss.xml",

            "{$host}/blog/feed",
            "{$host}/blog/index",
            "{$host}/blog/atom",
            "{$host}/blog/rss",

            "feed.{$host}",
            "rss.{$host}",
        ];
    }
}
