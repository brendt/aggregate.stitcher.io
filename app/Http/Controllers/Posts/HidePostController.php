<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;

final class HidePostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'hide_until' => now()->addMonths(3)
        ]);

        return redirect()->action(FindPostController::class);
    }
}
