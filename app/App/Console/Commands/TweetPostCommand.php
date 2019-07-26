<?php

namespace App\Console\Commands;

use Domain\Post\Models\Post;
use Domain\Tweet\Actions\TweetAction;
use Illuminate\Console\Command;

class TweetPostCommand extends Command
{
    protected $signature = 'tweet:post {uuid?} {--force}';

    public function handle(
        TweetAction $tweetAction
    ): void {
        $viewThreshold = 20;

        $postQuery = Post::query();

        if (! $this->option('force')) {
            $postQuery->whereNotTweeted();
        }

        if ($this->argument('uuid')) {
            $post = $postQuery
                ->where('uuid', $this->argument('uuid'))
                ->first();
        } else {
            $posts = $postQuery
                ->where('view_count', '>', $viewThreshold)
                ->where('created_at', '>', now()->subDays(4)->startOfDay()->toDateTimeString())
                ->get();

            if ($posts->isEmpty()) {
                $this->comment('No post found');

                return;
            }

            $post = $posts->random();
        }

        if (! $post) {
            $this->comment('No post found');

            return;
        }

        $this->info("Tweeting post {$post->uuid}");

        $tweetAction->execute($post);
    }
}
