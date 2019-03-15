<?php

namespace App\Console\Commands;

use Domain\Post\Models\Post;
use Domain\Tweet\Actions\TweetAction;
use Illuminate\Console\Command;

class TweetPostCommand extends Command
{
    protected $signature = 'tweet:post';

    public function handle(
        TweetAction $tweetAction
    ): void {
        $viewThreshold = 20;

        $posts = Post::query()
            ->whereNotTweeted()
            ->where('view_count', '>', $viewThreshold)
            ->where('created_at', '>', now()->subDays(4)->startOfDay()->toDateTimeString())
            ->get();

        if ($posts->isEmpty()) {
            $this->comment('No post found');

            return;
        }

        $post = $posts->random();

        $this->info("Tweeting post {$post->uuid}");

        $tweetAction->execute($post);
    }
}
