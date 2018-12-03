<?php

namespace App\Http\Controllers;

use Domain\Post\Models\Post;

class PostsController
{
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
}
