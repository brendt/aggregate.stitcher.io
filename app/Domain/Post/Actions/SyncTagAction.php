<?php

namespace App\Domain\Post\Actions;

use Domain\Post\Models\Tag;

class SyncTagAction
{
    public function __invoke(string $name, string $color, array $keywords): Tag
    {
        return Tag::updateOrCreate([
            'name' => $name,
        ], [
            'color' => $color,
            'keywords' => $keywords,
        ]);
    }
}
