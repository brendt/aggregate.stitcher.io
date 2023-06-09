<?php

namespace App\Services\PostSharing\Posters;

use App\Models\PostShare;
use App\Models\PostState;
use App\Services\PostSharing\ChannelPoster;

final class AggregatePoster implements ChannelPoster
{
    public function __construct() {}

    public function post(PostShare $postShare): void
    {
        $post = $postShare->post;

        if ($post->isPublished()) {
            return;
        }

        $post->update([
            'state' => PostState::PUBLISHED,
            'published_at' => now(),
        ]);

        $postShare->update([
            'shared_at' => now(),
        ]);
    }
}
