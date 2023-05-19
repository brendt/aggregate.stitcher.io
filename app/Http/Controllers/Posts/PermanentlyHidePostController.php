<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Http\Request;

final class PermanentlyHidePostController
{
    public function __invoke(Post $post, Request $request)
    {
        $post->update([
            'hide_until' => now()->addYears(100)
        ]);

        return redirect()->action(FindPostController::class, ['filter' => $request->get('filter')]);
    }
}
