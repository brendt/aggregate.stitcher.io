<?php

namespace App\Console\Commands;

use Domain\Post\Models\Post;
use Domain\Tweet\Actions\TweetAction;
use Illuminate\Console\Command;

class TweetTestCommand extends Command
{
    protected $name = 'tweet:test';

    public function handle(TweetAction $tweetAction): void
    {
        $post = Post::first();

        $tweetAction->execute($post);
    }
}
