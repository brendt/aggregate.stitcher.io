<?php

namespace Domain\Source\Actions;

use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;

final class UpdateSourceAction
{
    public function __invoke(Source $source, SourceData $sourceData): void
    {
        if (! $sourceData->hasChanges($source)) {
            return;
        }

        $source->url = $sourceData->url;

        $source->save();
    }
}
