<?php

namespace App\Services\PostSharing\Posters;

use App\Models\Post;
use App\Models\PostShare;
use App\Services\PostSharing\ChannelPoster;
use Illuminate\Support\Facades\Http;

final class HackerNewsPoster implements ChannelPoster
{
    public function __construct(
        private string $user,
        private string $password,
    ) {}

    public function post(Post $post, PostShare $postShare): void
    {
        $response = Http::post(
            url: 'https://news.ycombinator.com/login',
            data: [
                'acct' => $this->user,
                'pw' => $this->password,
            ],
        );

        dd($response->headers(), $response->body());
    }
}
