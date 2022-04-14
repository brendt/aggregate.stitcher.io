<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostState;

final class PublishPostController
{
    public function __invoke(Post $post)
    {
        $post->update([
            'state' => PostState::PUBLISHED,
        ]);

        return redirect()->action(HomeController::class, request()->query->all());
    }
}
