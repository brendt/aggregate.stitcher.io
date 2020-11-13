<?php

namespace App\Feed\Controllers;

use Domain\Source\Models\Source;
use Domain\Spam\Actions\SourceReportAction;
use Domain\User\Models\User;

final class SourceReportsController
{
    public function store(
        User $user,
        Source $source,
        SourceReportAction $reportAction
    ) {
        $reportAction($user, $source);

        return redirect()->back();
    }
}