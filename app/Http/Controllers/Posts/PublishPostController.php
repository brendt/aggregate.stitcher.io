<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Posts\AdminPostsController;
use App\Models\Post;
use App\Models\PostState;

final class PublishPostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'state' => PostState::PUBLISHED,
        ]);

        return redirect()->action(AdminPostsController::class, request()->query->all());
    }
}
