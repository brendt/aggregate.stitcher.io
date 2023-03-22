<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class FindPostController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->with('source')
            ->where('state', PostState::PUBLISHED)
            ->where(fn (Builder $builder) => $builder
                ->where('hide_until', '<', now())
                ->orWhereNull('hide_until'))
            ->orderByDesc('visits')
            ->where('published_at', '<', now()->subMonths(6))
            ->paginate(20);

        return view('find', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
        ]);
    }
}
