<?php

namespace App\Http\Controllers;

use App\Domain\Source\Actions\DeleteSourceAction;
use App\Http\Requests\SourceRequest;
use App\Http\ViewModels\SourceViewModel;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\Actions\UpdateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\User\Models\User;

class SourcesController
{
    public function edit(User $user)
    {
        $viewModel = new SourceViewModel($user);

        return $viewModel->view('sources.form');
    }

    public function update(
        SourceRequest $request,
        User $user,
        CreateSourceAction $createSourceAction,
        UpdateSourceAction $updateSourceAction
    ) {
        $sourceData = SourceData::fromRequest($request);

        $source = $user->getPrimarySource();

        if (! $source) {
            $createSourceAction->execute($user, $sourceData);
        } else {
            $updateSourceAction->execute($source, $sourceData);
        }

        return redirect()->action([self::class, 'edit']);
    }

    public function delete(
        User $user,
        DeleteSourceAction $deleteSourceAction
    ) {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            return redirect()->action([self::class, 'edit']);
        }

        $deleteSourceAction->execute($primarySource);

        return redirect()->action([self::class, 'edit']);
    }
}
