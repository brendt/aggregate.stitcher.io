<?php

namespace App\Http\Controllers;

use App\Domain\Post\Events\AddViewEvent;
use App\Http\Queries\ActiveSourcesQuery;
use App\Http\Queries\LatestPostsQuery;
use App\Http\Queries\AllPostsQuery;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Source\Models\Source;
use Illuminate\Http\Request;

class PostsController
{
    public function index(
        Request $request,
        ActiveSourcesQuery $sourcesQuery,
        AllPostsQuery $postsQuery
    ) {
        $currentTag = $this->getCurrentTag($request);

        $sources = $sourcesQuery->get();

        $posts = $postsQuery->paginate(15, ['posts.id']);

        $posts->appends($request->except('page'));

        return view('posts.index', [
            'sources' => $sources,
            'posts' => $posts,
            'user' => $request->user(),
            'currentTag' => $currentTag,
        ]);
    }

    public function latest(
        Request $request,
        LatestPostsQuery $query
    ) {
        $currentTag = $this->getCurrentTag($request);

        $sources = Source::whereActive()->get();

        $posts = $query->paginate();

        $posts->appends($request->except('page'));

        return view('posts.index', [
            'sources' => $sources,
            'posts' => $posts,
            'user' => $request->user(),
            'title' => __('Latest'),
            'currentTag' => $currentTag,
        ]);
    }

    public function show(
        Request $request,
        Post $post
    ) {
        event(AddViewEvent::create($post, $request->user()));

        return redirect()->to($post->url);
    }

    private function getCurrentTag(Request $request): ?Tag
    {
        $tagName = $request->get('filter')['tags.name'] ?? null;

        if (!$tagName) {
            return null;
        }

        return Tag::whereName($tagName)->first();
    }
}
