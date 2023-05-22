<?php

namespace App\Jobs;

use App\Actions\ParseRssFeed;
use App\Events\PostResolved;
use App\Models\Post;
use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Source $source,
    ) {}

    public function handle()
    {
        try {
            $xml = file_get_contents($this->source->url);

            $entries = (new ParseRssFeed($this->source))($xml);

            foreach ($entries as $entry) {
                $post = Post::updateOrCreate(
                    [
                        'source_id' => $this->source->id,
                        'url' => $entry->url,
                    ],
                    [
                        'title' => $entry->title,
                        'created_at' => $entry->createdAt,
                    ]
                );

                event(new PostResolved($post, $entry->payload));
            }
        } catch (Throwable $exception) {
            $this->source->markWithError($exception);
        }
    }
}
