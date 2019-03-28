<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Http\ViewModels\AdminAnalyticsViewModel;

final class AdminAnalyticsController
{
    public function index(Request $request)
    {
        $viewModel = new AdminAnalyticsViewModel($request);

        return $viewModel->view('adminAnalytics.index');
    }
}
