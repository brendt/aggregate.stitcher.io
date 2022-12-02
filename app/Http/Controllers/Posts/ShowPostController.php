<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostVisit;

final class ShowPostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'visits' => $post->visits + 1,
        ]);

        PostVisit::create([
            'post_id' => $post->id,
        ]);

        return redirect()->to($post->getFullUrl());
    }
}
