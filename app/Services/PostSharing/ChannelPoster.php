<?php

namespace App\Services\PostSharing;

use App\Models\Post;
use App\Models\PostShare;

interface ChannelPoster
{
    public function post(Post $post, PostShare $postShare): void;
}
