<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Jobs\AddPostVisitJob;
use App\Models\Post;

final class ShowPostController
{
    public function __invoke(Post $post)
    {
        dispatch(new AddPostVisitJob($post));

        return redirect()->to($post->getFullUrl());
    }
}
