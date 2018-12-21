<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddViewEvent;
use App\Http\Queries\LatestPostsQuery;
use App\Http\Queries\AllPostsQuery;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;
use Illuminate\Http\Request;

class PostsController
{
    public function index(
        Request $request,
        AllPostsQuery $query
    ) {
        $sources = Source::whereActive()->get();

        $posts = $query->paginate(15, ['posts.id']);

        $posts->appends($request->except('page'));

        return view('posts.index', [
            'sources' => $sources,
            'posts' => $posts,
            'user' => $request->user(),
        ]);
    }

    public function latest(
        Request $request,
        LatestPostsQuery $query
    ) {
        $sources = Source::whereActive()->get();

        $posts = $query->paginate();

        $posts->appends($request->except('page'));

        return view('posts.index', [
            'sources' => $sources,
            'posts' => $posts,
            'user' => $request->user(),
            'title' => __('Latest'),
        ]);
    }

    public function show(
        Request $request,
        Post $post
    ) {
        event(AddViewEvent::create($post, $request->user()));

        return redirect()->to($post->url);
    }
}
