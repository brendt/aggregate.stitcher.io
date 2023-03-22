<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;

final class PermanentlyHidePostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'hide_until' => now()->addYears(100)
        ]);

        return redirect()->action(FindPostController::class);
    }
}
