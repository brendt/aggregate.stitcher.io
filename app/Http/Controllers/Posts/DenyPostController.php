<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;

final class DenyPostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'state' => PostState::DENIED,
        ]);

        return redirect()->action(AdminPostsController::class, request()->query->all());
    }
}
