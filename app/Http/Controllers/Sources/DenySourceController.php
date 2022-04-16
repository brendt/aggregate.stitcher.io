<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Http\Controllers\Sources\AdminSourcesController;
use App\Models\Source;
use App\Models\SourceState;

final class DenySourceController
{
    public function __invoke(Source $source)
    {
        $source->update([
            'state' => SourceState::DENIED,
        ]);

        return redirect()->action(AdminSourcesController::class, request()->query->all());
    }
}
