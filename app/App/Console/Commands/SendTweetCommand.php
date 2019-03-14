<?php

namespace App\Console\Commands;

use Domain\Post\Models\Post;
use Domain\Tweet\Actions\TweetAction;
use Domain\Tweet\Api\TwitterGateway;
use Domain\Tweet\Models\Tweet;
use Illuminate\Console\Command;

class SendTweetCommand extends Command
{
    protected $signature = 'tweet:send {post} {--now} {--force}';

    public function handle(
        TweetAction $tweetAction,
        TwitterGateway $gateway
    ): void {
        $post = Post::whereUuid($this->argument('post'))->firstOrFail();

        if (! $this->option('force') && $post->hasBeenTweeted()) {
            $this->error("Post already tweeted");

            return;
        }

        if ($this->option('now')) {
            $gateway->tweet(Tweet::createForTweetable($post));

            $this->info('Tweet sent');
        } else {
            $tweetAction->execute($post);

            $this->info('Tweet scheduled');
        }
    }
}
