<?php

namespace Domain\Source\Actions;

use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;

final class UpdateSourceAction
{
    /** @var \Domain\Source\Actions\ResolveTopicsAction */
    private $resolveTopicsAction;

    public function __construct(ResolveTopicsAction $resolveTopicsAction)
    {
        $this->resolveTopicsAction = $resolveTopicsAction;
    }

    public function __invoke(Source $source, SourceData $sourceData): void
    {
        if (! $sourceData->hasChanges($source)) {
            return;
        }

        $source->url = $sourceData->url;
        $source->twitter_handle = $sourceData->twitter_handle;
        $source->is_active = $sourceData->is_active;
        $source->is_validated = $sourceData->is_validated;

        $source->save();

        $this->resolveTopicsAction->execute($source, $sourceData);
    }
}
