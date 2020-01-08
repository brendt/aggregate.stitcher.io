<?php

namespace App\Admin\Controllers;

use App\Admin\ViewModels\AdminAnalyticsViewModel;
use Support\Requests\Request;

final class AdminAnalyticsController
{
    public function index(Request $request)
    {
        $viewModel = new AdminAnalyticsViewModel($request);

        return $viewModel->view('adminAnalytics.index');
    }
}
