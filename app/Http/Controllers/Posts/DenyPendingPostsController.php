<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;

final class DenyPendingPostsController
{
    public function __invoke()
    {
        Post::query()
            ->where('state', PostState::PENDING)
            ->each(fn (Post $post) => $post->update([
                'state' => PostState::DENIED,
            ]));

        return redirect()->action(AdminPostsController::class, request()->query->all());
    }
}
