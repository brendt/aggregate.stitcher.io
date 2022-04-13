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
        $query = Post::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $user = $request->user();

        $showDenied = $request->has('denied');

        $onlyPending = $request->has('only_pending');

        if ($user) {
            $states = [PostState::PENDING];

            if (! $onlyPending) {
                $states[] = PostState::PUBLISHED;
                $states[] = PostState::STARRED;
            }

            if ($showDenied) {
                $states[] = PostState::DENIED;
            }

            $query->whereIn('state', $states);
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
            'onlyPending' => $onlyPending,
        ]);
    }
}
