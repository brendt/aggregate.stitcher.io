<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddViewEvent;
use App\Http\Queries\LatestPostsQuery;
use App\Http\Queries\AllPostsQuery;
use App\Http\Requests\PostIndexRequest;
use App\Http\ViewModels\PostsViewModel;
use Domain\Post\Models\Post;
use Illuminate\Http\Request;

class PostsController
{
    public function index(
        PostIndexRequest $request,
        AllPostsQuery $postsQuery
    ) {
        $posts = $postsQuery->paginate(15, ['posts.id']);

        $posts->appends($request->except('page'));

        $viewModel = (new PostsViewModel($request, $posts))
            ->withTitle(__('All'))
            ->view('posts.index');

        return $viewModel;
    }

    public function latest(
        PostIndexRequest $request,
        LatestPostsQuery $query
    ) {
        $posts = $query->paginate();

        $posts->appends($request->except('page'));

        $viewModel = (new PostsViewModel($request, $posts))
            ->withTitle(__('Latest'))
            ->view('posts.index');

        return $viewModel;
    }

    public function show(
        Request $request,
        Post $post
    ) {
        event(AddViewEvent::create($post, $request->user()));

        return redirect()->to($post->url);
    }
}
