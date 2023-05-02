<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class TopPostController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->with('source')
            ->where('state', PostState::PUBLISHED)
            ->orderByDesc('visits')
            ->paginate(20);

        return view('home', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
        ]);
    }
}
