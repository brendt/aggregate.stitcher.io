<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Http\Controllers\Sources\AdminSourcesController;
use App\Jobs\PublishSourceJob;
use App\Models\Source;
use App\Models\SourceState;

final class PublishSourceController
{
    public function __invoke(Source $source)
    {
        $source->update([
            'state' => SourceState::PUBLISHING,
        ]);

        dispatch(new PublishSourceJob($source));

        return redirect()->action(AdminSourcesController::class, request()->query->all());
    }
}
