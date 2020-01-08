<?php

namespace App\User\Controllers;

use App\Feed\ViewModels\SourceViewModel;
use App\User\Requests\UserSourceRequest;
use Domain\Language\LanguageRepository;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\Actions\DeleteSourceAction;
use Domain\Source\Actions\UpdateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\User\Models\User;

final class UserSourcesController
{
    public function index(User $user, LanguageRepository $languageRepository)
    {
        $viewModel = new SourceViewModel($user, $languageRepository);

        return $viewModel->view('userSources.index');
    }

    public function update(
        UserSourceRequest $request,
        User $user,
        CreateSourceAction $createSourceAction,
        UpdateSourceAction $updateSourceAction
    ) {
        $primarySource = $user->getPrimarySource();

        $sourceData = SourceData::fromRequest($request, $primarySource);

        if (! $primarySource) {
            $createSourceAction($user, $sourceData);

            return redirect()->action([self::class, 'index']);
        }

        $updateSourceAction($primarySource, $sourceData);

        return redirect()->action([self::class, 'index']);
    }

    public function confirmDelete(User $user)
    {
        return view('userSources.delete', [
            'source' => $user->getPrimarySource(),
        ]);
    }

    public function delete(
        User $user,
        DeleteSourceAction $deleteSourceAction
    ) {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            return redirect()->action([self::class, 'index']);
        }

        $deleteSourceAction($primarySource);

        return redirect()->action([self::class, 'index']);
    }
}
