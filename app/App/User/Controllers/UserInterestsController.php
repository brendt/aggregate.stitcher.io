<?php

namespace App\User\Controllers;

use App\User\Requests\UserInterestsRequest;
use App\User\ViewModels\UserInterestsViewModel;
use Domain\User\Actions\ResolveUserInterestsAction;
use Domain\User\Models\User;

final class UserInterestsController
{
    public function index(User $user)
    {
        $viewModel = new UserInterestsViewModel($user);

        return $viewModel->view('userInterests.index');
    }

    public function update(
        User $user,
        ResolveUserInterestsAction $resolveUserInterestsAction,
        UserInterestsRequest $userInterestsRequest
    ) {
        $topicIds = $userInterestsRequest->get('topics', []);

        $resolveUserInterestsAction($user, $topicIds);

        flash('Saved');

        return redirect()->back();
    }
}
