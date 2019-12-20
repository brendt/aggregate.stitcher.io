<?php

namespace App\Admin\Controllers;

use Support\Requests\Request;
use App\Admin\ViewModels\AdminAnalyticsViewModel;

final class AdminAnalyticsController
{
    public function index(Request $request)
    {
        $viewModel = new AdminAnalyticsViewModel($request);

        return $viewModel->view('adminAnalytics.index');
    }
}
