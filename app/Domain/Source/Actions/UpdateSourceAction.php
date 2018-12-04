<?php

namespace Domain\Source\Actions;

use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;

class UpdateSourceAction
{
    public function execute(
        Source $source,
        SourceData $sourceData
    ): Source {
        $source->fill($sourceData->all());

        $source->save();

        return $source->refresh();
    }
}
