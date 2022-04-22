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

        $meta = get_meta_tags($url);

        Post::create([
            'state' => PostState::PUBLISHED,
            'title' => $meta['title'] ?? $url,
            'url' => $url,
        ]);

        return redirect()->action(AdminPostsController::class);
    }
}
