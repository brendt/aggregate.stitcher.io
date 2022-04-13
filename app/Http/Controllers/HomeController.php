<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Http\Request;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $query = Post::query()->orderByDesc('created_at');

        $user = $request->user();

        $showDenied = $request->has('denied');

        if ($user) {
            $query->whereIn('state', [
                PostState::PENDING,
                PostState::PUBLISHED,
                PostState::STARRED,
                $showDenied ? PostState::DENIED : null,
            ]);
        } else {
            $query->whereIn('state', [
                PostState::PUBLISHED,
                PostState::STARRED,
            ]);
        }

        $posts = $query->paginate(50);

        return view('home', [
            'posts' => $posts,
            'user' => $user,
            'showDenied' => $showDenied,
        ]);
    }
}
