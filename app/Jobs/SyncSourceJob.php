<?php

namespace App\Jobs;

use App\Events\PostResolved;
use App\Models\Post;
use App\Models\Source;
use Carbon\Carbon;
use Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Source $source,
    ) {
    }

    public function handle()
    {
        $feed = Feed::load($this->source->url);

        foreach ($this->resolveItems($feed) as $payload) {
            $post = Post::updateOrCreate(
                [
                    'source_id' => $this->source->id,
                    'url' => $this->resolveId($payload),
                ],
                [
                    'title' => $this->resolveTitle($payload),
                    'created_at' => $this->resolveCreatedAt($payload),
                ]
            );

            event(new PostResolved($post, $payload));
        }
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

        return html_entity_decode($title);
    }

    private function resolveItems(Feed $feed): mixed
    {
        $array = $feed->toArray();

        return $array['entry'] ?? $array['item'];
    }

    private function resolveId(array $item): string
    {
        if ($this->source->isExternals()) {
            return $this->resolveIdForExternals($item);
        }

        return $item['id'] ?? $item['link'];
    }

    private function resolveCreatedAt(array $item): ?Carbon
    {
        $updated = $item['published']
            ?? $item['pubDate']
            ?? $item['updated']
            ?? $item['timestamp'];

        return Carbon::make($updated);
    }

    public function resolveIdForExternals(array $item): string
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
}
