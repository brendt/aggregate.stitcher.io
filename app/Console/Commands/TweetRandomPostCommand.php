<?php

namespace App\Console\Commands;

use App\Actions\TweetPost;
use App\Models\Post;
use App\Models\PostState;
use App\Models\Source;
use Illuminate\Console\Command;

final class TweetRandomPostCommand extends Command
{
    protected $signature = 'tweet:random-post';

    public function handle(TweetPost $tweetPost)
    {
        // Time sensitive sources or irrelevant source
        $ignoreSources = Source::query()
            ->whereIn('name', [
                'https://aegir.org',
                'https://xkcd.com',
                'https://externals.io',
                'https://blog.jetbrains.com',
                'https://stitcher.io',
            ])
            ->get()
            ->pluck('id');

        $post = Post::query()
            ->where('state', PostState::PUBLISHED)
            ->where('visits', '>', 50)
            ->whereNotIn('source_id', $ignoreSources)
            ->whereNull('tweet_id')
            ->orderByRaw('RAND()')
            ->limit(1)
            ->first();

        $tweetPost($post);

        $this->info("Tweeted about {$post->title}");
    }
}
