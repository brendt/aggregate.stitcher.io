<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\SourceState;

final class DenySourceController
{
    public function __invoke(Source $source)
    {
        $source->update([
            'state' => SourceState::DENIED,
        ]);

        return redirect()->action(SourcesAdminController::class, request()->query->all());
    }
}
