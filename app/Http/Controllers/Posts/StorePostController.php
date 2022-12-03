<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Models\PostState;
use Illuminate\Http\Request;

final class StorePostController
{
    public function __invoke(Request $request)
    {
        $url = $request->validate([
            'url' => ['url', 'required']
        ])['url'];

        Post::create([
            'state' => PostState::PUBLISHED,
            'title' => getTitle($url),
            'url' => $url,
            'published_at' => now(),
        ]);

        return redirect()->action(AdminPostsController::class);
    }
}
