<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\ViewModels\ProfileViewModel;
use Domain\User\Actions\ChangePasswordAction;
use Domain\User\Models\User;
use Illuminate\Http\RedirectResponse;

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
        $changePasswordAction($user, $request->input('password'));

        return redirect()->back()->with('success', 'Votre mot de passe a bien été modifé');
    }
}
