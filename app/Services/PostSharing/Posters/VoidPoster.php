<?php

namespace App\Services\PostSharing\Posters;

use App\Models\PostShare;
use App\Services\PostSharing\ChannelPoster;

final class VoidPoster implements ChannelPoster
{
    public function post(PostShare $postShare): void
    {
        // Nothing
    }
}
