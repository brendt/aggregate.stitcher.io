<?php

namespace App\Services\PostSharing;

use App\Models\PostShare;

interface ChannelPoster
{
    public function post(PostShare $postShare): void;
}
