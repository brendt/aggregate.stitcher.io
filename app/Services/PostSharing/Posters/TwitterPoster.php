<?php

namespace App\Services\PostSharing\Posters;

use App\Models\PostShare;
use App\Services\OAuth\TwitterHttpClient;
use App\Services\PostSharing\ChannelPoster;

final class TwitterPoster implements ChannelPoster
{
    public function __construct(
        private TwitterHttpClient $twitter,
    ) {}

    public function post(PostShare $postShare): void
    {
        // Just in case something goes wrong: I don't want to spam Twitter, so I immediately set shared at.
//        $postShare->update([
//            'shared_at' => now(),
//        ]);

        $response = $this->twitter->tweet($postShare->post->getTweetMessage());

        $postShare->update([
            'reference' => json_encode($response),
        ]);
    }
}
