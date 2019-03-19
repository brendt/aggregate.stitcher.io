<?php

namespace App\Http\Controllers;

use Domain\Post\Models\Post;
use Domain\Tweet\Actions\TweetAction;
use Illuminate\Http\Response;

class PostTweetController
{
    public function __invoke(
        Post $post,
        TweetAction $tweetAction
    ) {
        abort_if($post->hasBeenTweeted(), Response::HTTP_BAD_REQUEST, 'Post has been tweeted before.');

        $tweetAction
            ->onQueue()
            ->execute($post);
    }
}
