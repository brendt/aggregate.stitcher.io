<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

final class StorePostCommentController
{
    public function __invoke(Post $post, Request $request)
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'min:3']
        ]);

        PostComment::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'comment' => $validated['comment'],
        ]);

        $post->update([
            'last_comment_at' => now(),
        ]);

        return redirect()->action(PostCommentsController::class, $post->uuid);
    }
}
