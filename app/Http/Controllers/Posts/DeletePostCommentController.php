<?php

namespace App\Http\Controllers\Posts;

use App\Models\PostComment;

final class DeletePostCommentController
{
    public function __invoke(PostComment $postComment)
    {
        $postComment->delete();

        return redirect()->action(PostCommentsController::class, $postComment->post_id);
    }
}
