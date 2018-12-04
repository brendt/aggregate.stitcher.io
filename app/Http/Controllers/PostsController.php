<?php

namespace App\Http\Controllers;

use App\Http\Queries\PostsQuery;
use Domain\Post\Actions\AddViewAction;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class PostsController
{
    public function index(PostsQuery $query)
    {
        $posts = $query->paginate();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(
        Request $request,
        Post $post,
        AddViewAction $addViewAction
    ) {
        $addViewAction->execute($post, $request->user());

        return redirect()->to($post->url);
    }
}
