<?php

namespace App\Feed\Controllers;

use App\Feed\ViewModels\SourceReportViewModel;
use App\User\Requests\SourceReportRequest;
use Domain\Source\Models\Source;
use Domain\Spam\Actions\SourceReportAction;
use Domain\User\Models\User;

final class SourceReportsController
{
    public function showReportForm(Source $source)
    {
        $viewModel = new SourceReportViewModel($source);
        return $viewModel->view('userReports.index');
    }

    public function store(
        SourceReportRequest $reportRequest,
        User $user,
        Source $source,
        SourceReportAction $reportAction
    ) {
        $reportAction($user, $source, $reportRequest->get('report'));
        flash('Spam reported!');
        return redirect()->action([PostsController::class, 'all']);
    }
}