<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostState;
use App\Models\SourceState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->whereHas('source', function (Builder $query) {
                $query->where('state', SourceState::PUBLISHED);
            })
            ->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ])
            ->paginate(20);

        return view('home', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
        ]);
    }
}
