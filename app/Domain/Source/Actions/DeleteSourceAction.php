<?php

namespace Domain\Source\Actions;

use Domain\Source\Models\Source;

final class DeleteSourceAction
{
    public function __invoke(Source $source): void
    {
        $source->delete();
    }
}
