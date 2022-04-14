<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Source;

final class SourcesAdminController
{
    public function __invoke()
    {
        $sources = Source::query()->orderByDesc('id')->get();

        return view('sourcesAdmin', [
            'sources' => $sources,
        ]);
    }
}
