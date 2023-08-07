<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddPostVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $postId
    ) {}

    public function handle()
    {
        $post = Post::find($this->postId);

        $post->update([
            'visits' => $post->visits + 1,
        ]);

        PostVisit::create([
            'post_id' => $post->id,
        ]);

        $post->source->increment('visits');

//        Post::query()
//            ->homePage()
//            ->paginate(20)
//            ->each(function (Post $post) {
//                Cache::forget($post->getVisitsGraphCacheKey());
//
//                $post->getSparkLine();
//            });

//        Cache::forget($post->getVisitsGraphCacheKey());
    }
}
