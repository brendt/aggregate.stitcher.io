<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

final class CreatePostController
{
    public function __invoke()
    {
        return view('createPost');
    }
}
