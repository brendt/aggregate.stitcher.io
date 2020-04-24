<?php

namespace App\Admin\Controllers;

use App\Admin\ViewModels\AdminAnalyticsViewModel;
use App\Admin\ViewModels\AdminPageCacheReportsModel;
use Domain\Analytics\Models\PageCacheReport;
use Support\Requests\Request;

final class AdminAnalyticsController
{
    public function index(Request $request)
    {
        $viewModel = new AdminAnalyticsViewModel($request);

        return $viewModel->view('adminAnalytics.index');
    }

    public function pageCache()
    {
        $pageCacheReports = PageCacheReport::all();

        $viewModel = new AdminPageCacheReportsModel($pageCacheReports);

        return $viewModel->view('adminAnalytics.pageCacheReports');
    }
}
