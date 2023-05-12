<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Http\Request;

final class PostCommentsController
{
    public function __invoke(Post $post, Request $request)
    {
        $post->load([
            'comments.user'
        ]);

        $user = $request->user();

        $lastSeenAt = $user?->lastSeenAt($post);

        if ($user) {
            $user->addPostVisit($post);
        }

        return view('postComments', [
            'post' => $post,
            'user' => $user,
            'lastSeenAt' => $lastSeenAt,
        ]);
    }
}
