<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Models\Source;

final class AdminSourcesController
{
    public function __invoke()
    {
        $sources = Source::query()->orderByDesc('id')->get();

        return view('adminSources', [
            'sources' => $sources,
        ]);
    }
}
