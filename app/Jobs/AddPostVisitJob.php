<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostState;
use App\Models\PostVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class AddPostVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Post $post
    ) {}

    public function handle()
    {
        $this->post->update([
            'visits' => $this->post->visits + 1,
        ]);

        PostVisit::create([
            'post_id' => $this->post->id,
        ]);

        Post::query()
            ->homePage()
            ->paginate(20)
            ->each(function (Post $post) {
                Cache::delete($post->getVisitsGraphCacheKey());

                $post->getSparkLine();
            });
    }
}
