<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

        return redirect()->action(SourcesAdminController::class, request()->query->all());
    }
}
