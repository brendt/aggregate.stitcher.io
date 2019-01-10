<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddViewEvent;
use App\Http\Queries\LatestPostsQuery;
use App\Http\Queries\AllPostsQuery;
use App\Http\Requests\PostIndexRequest;
use App\Http\ViewModels\PostsViewModel;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Illuminate\Http\Request;

class PostsController
{
    public function index(
        PostIndexRequest $request,
        AllPostsQuery $query
    ) {
        $posts = $query->paginate();

        $posts->appends($request->except('page'));

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($request->getTopicSlug())
            ->withTagSlug($request->getTagSlug())
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

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($request->getTopicSlug())
            ->withTagSlug($request->getTagSlug())
            ->withTitle(__('Latest'))
            ->view('posts.index');

        return $viewModel;
    }

    public function topic(
        PostIndexRequest $request,
        AllPostsQuery $query,
        Topic $topic
    ) {
        $posts = $query->whereTopic($topic)->paginate();

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($topic->slug)
            ->withTagSlug($request->getTagSlug())
            ->view('posts.index');

        return $viewModel;
    }

    public function tag(
        PostIndexRequest $request,
        AllPostsQuery $query,
        Tag $tag
    ) {
        $posts = $query->whereTag($tag)->paginate();

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($tag->topic->slug)
            ->withTagSlug($tag->slug)
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
