<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Http\Request;

final class TopController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->orderByDesc('visits')
            ->whereActiveSource()
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
