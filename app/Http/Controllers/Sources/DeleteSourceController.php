<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Http\Controllers\Sources\AdminSourcesController;
use App\Models\Post;
use App\Models\Source;

final class DeleteSourceController
{
    public function __invoke(Source $source)
    {
        $source->posts->each(fn(Post $post) => $post->delete());

        $source->delete();

        return redirect()->action(AdminSourcesController::class, request()->query->all());
    }
}
