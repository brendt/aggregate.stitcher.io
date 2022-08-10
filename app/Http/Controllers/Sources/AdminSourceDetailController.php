<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Models\Source;

final class AdminSourceDetailController
{
    public function __invoke(Source $source)
    {
        $source = $source->load('posts');

        return view('adminSourceDetail', [
            'source' => $source,
        ]);
    }
}
