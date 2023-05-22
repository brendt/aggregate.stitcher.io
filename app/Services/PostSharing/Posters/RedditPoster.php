<?php

namespace App\Services\PostSharing\Posters;

use App\Models\PostShare;
use App\Services\OAuth\RedditHttpClient;
use App\Services\PostSharing\ChannelPoster;

final class RedditPoster implements ChannelPoster
{
    public function __construct(
        private RedditHttpClient $reddit,
        private string $subReddit,
    ) {}

    public function post(PostShare $postShare): void
    {
        if (! app()->environment('local')) {
            $postShare->update([
                'shared_at' => now(),
            ]);
        }

        $response = $this->reddit->submitLink(
            subReddit: $this->subReddit,
            url: $postShare->post->getFullUrl(),
            title: $postShare->post->title,
        );

        $postShare->update([
            'reference' => json_encode($response->body()),
        ]);
    }
}
