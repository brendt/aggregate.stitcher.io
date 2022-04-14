<?php

namespace App\Jobs;

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

        foreach ($this->resolveItems($feed) as $item) {
            Post::updateOrCreate(
                [
                    'source_id' => $this->source->id,
                    'url' => $this->resolveId($item),
                ],
                [
                    'title' => $this->resolveTitle($item),
                    'created_at' => $this->resolveCreatedAt($item),
                ]
            );
        }
    }

    private function resolveTitle(array $item): string
    {
        if (is_string($item['title'] ?? null)) {
            return $item['title'];
        }

        return $item['id'];
    }

    private function resolveItems(Feed $feed): mixed
    {
        $array = $feed->toArray();

        return $array['entry'] ?? $array['item'];
    }

    private function resolveId(array $item): string
    {
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
}
