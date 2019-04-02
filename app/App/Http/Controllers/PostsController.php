<?php

namespace App\Http\Controllers;

use App\Console\Jobs\PostViewedJob;
use App\Http\Queries\AllPostsQuery;
use App\Http\Queries\LatestPostsQuery;
use App\Http\Queries\TopPostsQuery;
use App\Http\Requests\PostIndexRequest;
use App\Http\ViewModels\PostsViewModel;
use Domain\Post\Actions\AddViewAction;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Illuminate\Http\Request;
use Spatie\QueryString\QueryString;

final class PostsController
{
    public function index(
        PostIndexRequest $request,
        TopPostsQuery $query
    ) {
        $posts = $query->paginate(5);

        $posts->appends($request->except('page'));

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($request->getTopicSlug())
            ->withTagSlug($request->getTagSlug())
            ->withTitle(__('All'))
            ->view('home.index');

        return $viewModel;
    }

    public function all(
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

    public function top(
        PostIndexRequest $request,
        TopPostsQuery $query
    ) {
        $posts = $query->paginate();

        $posts->appends($request->except('page'));

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withTopicSlug($request->getTopicSlug())
            ->withTagSlug($request->getTagSlug())
            ->withTitle(__('Top this week'))
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

    public function source(
        PostIndexRequest $request,
        AllPostsQuery $query,
        Source $sourceByWebsite
    ) {
        $posts = $query->whereSource($sourceByWebsite)->paginate();

        $viewModel = (new PostsViewModel($posts, $request->user()))
            ->withSourceWebsite($sourceByWebsite->website)
            ->withTagSlug($request->getTagSlug())
            ->withTopicSlug($request->getTopicSlug())
            ->view('posts.index');

        return $viewModel;
    }

    public function show(
        Request $request,
        Post $post,
        AddViewAction $addViewAction
    ) {
        dispatch(new PostViewedJob(
            $addViewAction,
            $post,
            $request->user()
        ));

        $queryString = (new QueryString($post->getFullUrl()))->enable('ref', 'aggregate.stitcher.io');

        return redirect()->to((string) $queryString);
    }
}
