<?php

namespace App\Posts;

use App\Posts\Events\PostSynced;
use App\Posts\Events\SourceSynced;
use App\Posts\Events\SourceSyncFailed;
use Tempest\Cache\Cache;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\Duration;
use Tempest\Support\Arr\ImmutableArray;
use Throwable;
use function Tempest\event;
use function Tempest\Support\arr;

final readonly class SyncSource
{
    public function __construct(
        private Cache $cache,
    ) {}

    public function __invoke(Source $source): void
    {
        $xml = $this->cache->resolve(
            'source_' . $source->id,
            fn () => @file_get_contents($source->uri),
            Duration::minutes(10),
        );

        if ($xml === false) {
            event(new SourceSyncFailed($source->uri));

            return;
        }

        try {
            $this->parseXml($xml, $source)
                ->each(function (RssEntry $entry) use ($source) {
                    $post = Post::select()
                        ->where('posts.uri = ?', $entry->uri)
                        ->with('source')
                        ->first();

                    if (! $post) {
                        $post = Post::new(
                            uri: $entry->uri,
                            source: $source,
                        );
                    }

                    $post->title = $entry->title;
                    $post->createdAt = $entry->createdAt;

                    $post->save();

                    event(new PostSynced($post->uri));
                });
            event(new SourceSynced($source->uri));
        } catch (Throwable) {
            event(new SourceSyncFailed($source->uri));
        }
    }

    private function parseXml(string $input, Source $source): ImmutableArray
    {
        $xml = simplexml_load_string($input, "SimpleXMLElement", LIBXML_NOCDATA | LIBXML_NOWARNING | LIBXML_NOERROR);

        if (! $xml) {
            return arr();
        }

        $json = json_encode($xml);
        $array = json_decode($json, true, flags: JSON_THROW_ON_ERROR);

        return $this->resolveItems($array)
            ->map(function (array $item) use ($source) {
                return new RssEntry(
                    uri: $this->resolveUrl($source, $item),
                    title: $this->resolveTitle($item),
                    createdAt: $this->resolveCreatedAt($item),
                    payload: $item,
                );
            });
    }

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

        return trim(html_entity_decode(html_entity_decode($title)));
    }

    private function resolveUrl(Source $source, $item): string
    {
        if ($source->isExternals) {
            return $this->resolveUrlForExternals($source, $item);
        }

        $id = $item['id'] ?? null;

        if (filter_var($id, FILTER_VALIDATE_URL)) {
            return $id;
        }

        return $item['link']['@attributes']['href'] ?? $item['link'];
    }

    private function resolveCreatedAt(array $item): ?DateTime
    {
        $updated = $item['published']
            ?? $item['pubDate']
            ?? $item['updated']
            ?? $item['timestamp'];

        return DateTime::parse($updated);
    }

    public function resolveUrlForExternals(Source $source, $item): string
    {
        $existingPost = Post::select()
            ->where('title', $item['title'])
            ->where('source_id', $source->id)
            ->first();

        if ($existingPost) {
            return $existingPost->uri;
        }

        return $item['link'];
    }

    private function resolveItems(mixed $array): ImmutableArray
    {
        if (! is_array($array)) {
            return arr();
        }

        return arr(
            $array['entry']
            ?? $array['entries']
            ?? $array['item']
            ?? $array['items']
            ?? $array['channel']['item'],
        );
    }
}
