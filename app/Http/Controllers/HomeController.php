<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreatePostVisitsGraph;
use App\Models\Post;
use App\Models\PostState;
use Illuminate\Http\Request;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->homePage()
            ->paginate(20);

        return view('home', [
            'user' => $request->user(),
            'posts' => $posts,
            'message' => $request->get('message'),
        ]);
    }
}
