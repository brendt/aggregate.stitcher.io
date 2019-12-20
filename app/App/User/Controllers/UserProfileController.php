<?php

namespace App\User\Controllers;

use App\User\Requests\AddLanguageRequest;
use App\User\Requests\ProfilePasswordRequest;
use App\User\Requests\RemoveLanguageRequest;
use App\User\ViewModels\ProfileViewModel;
use Domain\Language\LanguageRepository;
use Domain\User\Actions\AddLanguageAction;
use Domain\User\Actions\ChangePasswordAction;
use Domain\User\Actions\RemoveLanguageAction;
use Domain\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

final class UserProfileController
{
    public function index(User $user, LanguageRepository $languageRepository)
    {
        return (new ProfileViewModel($user, $languageRepository))->view('userProfile.index');
    }

    public function addLanguage(
        User $user,
        LanguageRepository $languageRepository,
        AddLanguageRequest $addLanguageRequest,
        AddLanguageAction $addLanguageAction
    ) {
        $language = $languageRepository->find($addLanguageRequest->get('language'));

        $addLanguageAction($user, $language);

        flash('Languages updated');

        return redirect()->back();
    }

    public function removeLanguage(
        User $user,
        LanguageRepository $languageRepository,
        RemoveLanguageRequest $removeLanguageRequest,
        RemoveLanguageAction $removeLanguageAction
    ) {
        $language = $languageRepository->find($removeLanguageRequest->get('language'));

        $removeLanguageAction($user, $language);

        flash('Languages updated');

        return redirect()->back();
    }

    public function updatePassword(
        User $user,
        ProfilePasswordRequest $request,
        ChangePasswordAction $changePasswordAction
    ): RedirectResponse {
        $newPassword = Hash::make($request->input('password'));

        $changePasswordAction($user, $newPassword);

        flash('Password changed');

        return redirect()->back();
    }
}
