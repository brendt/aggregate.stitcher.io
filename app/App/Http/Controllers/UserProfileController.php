<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\ViewModels\ProfileViewModel;
use Domain\User\Actions\ChangePasswordAction;
use Domain\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserProfileController
{
    public function index(User $user)
    {
        return (new ProfileViewModel($user))->view('userProfile.index');
    }

    public function update(
        User $user,
        ProfileRequest $request,
        ChangePasswordAction $changePasswordAction
    ): RedirectResponse {
        $newPassword = Hash::make($request->input('password'));
        $changePasswordAction($user, $newPassword);

        return redirect()->back();
    }
}
