<?php

namespace App\Actions;

use App\Models\Post;
use DG\Twitter\Twitter;

final readonly class TweetPost
{
    public function __construct(
        private Twitter $twitter
    ) {}

    public function __invoke(Post $post)
    {
        $message = $post->title;

        if ($handle = $post->source->twitter_handle) {
            $message .= " by {$handle}";
        }

        $message .= PHP_EOL . PHP_EOL . $post->getPublicUrl();

        $response = $this->twitter->send($message);

        $post->update([
            'tweet_id' => $response->id,
        ]);
    }
}
