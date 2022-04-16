<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;

final class ShowPostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'visits' => $post->visits + 1,
        ]);

        return redirect()->to($post->url);
    }
}
