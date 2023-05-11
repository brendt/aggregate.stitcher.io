<?php

namespace App\Actions;

use App\Data\RssEntry;
use App\Models\Post;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class ParseRssFeed
{
    public function __construct(
        private Source $source,
    ) {}

    private function resolveTitle(array $item): string
    {
        $title = $item['title'] ?? null;

        if (! $title) {
            $meta = get_meta_tags($item['id']);

            return $meta['title']
                ?? $meta['twitter:title']
                ?? $meta['og:title']
                ?? $item['id'];
        }

        $title = preg_replace_callback("/(&#[0-9]+;)/", function ($match) {
            return mb_convert_encoding($match[1], "UTF-8", "HTML-ENTITIES");
        }, $title);

        return html_entity_decode($title);
    }

    private function resolveUrl(array $item): string
    {
        if ($this->source->isExternals()) {
            return $this->resolveUrlForExternals($item);
        }

        $id = $item['id'] ?? null;

        if (filter_var($id, FILTER_VALIDATE_URL)) {
            return $id;
        }

        return $item['link']['@attributes']['href'] ?? $item['link'];
    }

    /**
     * @param string $xml
     *
     * @return \App\Data\RssEntry[]|\Illuminate\Support\Collection
     */
    public function __invoke(string $xml): Collection
    {
        $xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA | LIBXML_NOERROR);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $this->resolveItems($array)
            ->map(function (array $item) {
                return new RssEntry(
                    url: $this->resolveUrl($item),
                    title: $this->decode($this->resolveTitle($item)),
                    createdAt: $this->resolveCreatedAt($item),
                    payload: $item,
                );
            });
    }

    private function resolveCreatedAt(array $item): ?Carbon
    {
        $updated = $item['published']
            ?? $item['pubDate']
            ?? $item['updated']
            ?? $item['timestamp'];

        return Carbon::make($updated);
    }

    public function resolveUrlForExternals(array $item): string
    {
        $existingPost = Post::query()
            ->where('title', $item['title'])
            ->where('source_id', $this->source->id)
            ->first();

        if ($existingPost) {
            return $existingPost->url;
        }

        return $item['link'];
    }

    private function decode(string $string): string
    {
        return html_entity_decode($string);
    }

    private function resolveItems(mixed $array): Collection
    {
        return collect(
            $array['entry']
            ?? $array['entries']
            ?? $array['item']
            ?? $array['items']
            ?? $array['channel']['item']
        );
    }
}
