<?php

namespace App\Http\Controllers;

use Domain\Post\Actions\AddViewAction;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class PostsController
{
    public function index()
    {
        $posts = Post::whereActive()->get();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(
        Request $request,
        Post $post,
        AddViewAction $addViewAction
    ) {
        $post = $addViewAction->execute($post, $request->user());

        return redirect()->to($post->url);
    }
}
