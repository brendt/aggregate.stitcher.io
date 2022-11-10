<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Http\Request;

final class PublishPostController
{
    public function __invoke(Request $request, Post $post)
    {
        $post->update([
            'state' => PostState::PUBLISHED,
            'published_at' => now(),
        ]);

        $returnUrl = $request->query->get(
            'ref',
            action(AdminPostsController::class, request()->query->all())
        );

        return redirect()->to($returnUrl);
    }
}
