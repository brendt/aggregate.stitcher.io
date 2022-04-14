<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source;

final class DeleteSourceController
{
    public function __invoke(Source $source)
    {
        $source->posts->each(fn(Post $post) => $post->delete());

        $source->delete();

        return redirect()->action(SourcesAdminController::class, request()->query->all());
    }
}
