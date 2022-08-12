<?php declare(strict_types=1);

namespace App\Actions;

use App\Models\Post;
use App\Models\PostState;
use App\Models\PostType;
use App\Models\Tweet;
use App\Models\TweetState;

final class PublishTweet
{
    public function __invoke(Tweet $tweet): void
    {
        $tweet->update([
            'state' => TweetState::PUBLISHED,
        ]);

        Post::create([
            'created_at' => $tweet->created_at,
            'state' => PostState::PUBLISHED,
            'type' => PostType::TWEET,
            'title' => $tweet->user_name,
            'body' => $tweet->text,
            'url' => $tweet->getPublicUrl(),
        ]);
    }
}
