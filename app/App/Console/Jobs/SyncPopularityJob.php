<?php

namespace App\Console\Jobs;

use Domain\Post\Actions\SyncPopularityAction;
use Domain\Post\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Support\PageCache\PageCache;

final class SyncPopularityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Post\Actions\SyncPopularityAction */
    private $syncPopularityAction;

    public function __construct(SyncPopularityAction $syncPopularityAction)
    {
        $this->syncPopularityAction = $syncPopularityAction;
    }

    public function handle(): void
    {
        $posts = Post::withActivePopularityIndex()->get();

        foreach ($posts as $post) {
            ($this->syncPopularityAction)($post);
        }

        PageCache::flush();
    }
}
