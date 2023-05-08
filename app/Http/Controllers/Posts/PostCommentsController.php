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

        return view('postComments', [
            'post' => $post,
            'user' => $request->user()
        ]);
    }
}
