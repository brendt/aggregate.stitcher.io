<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Models\Source;
use Illuminate\Http\Request;

final class AdminSourcesController
{
    public function __invoke(Request $request)
    {
        $query = Source::query()->orderByDesc('id');

        if ($request->has('error')) {
            $query->whereNotNull('last_error_at');
        }

        $sources = $query->get();

        return view('adminSources', [
            'sources' => $sources,
        ]);
    }
}
