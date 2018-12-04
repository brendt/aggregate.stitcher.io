<?php

namespace App\Domain\Source\Actions;

use Domain\Source\Models\Source;

class DeleteSourceAction
{
    public function execute(Source $source)
    {
        $source->delete();
    }
}
