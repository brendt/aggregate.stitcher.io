<?php

namespace App\Http\Controllers;

use Domain\Source\Events\CreateSourceEvent;
use Domain\Source\Events\DeleteSourceEvent;
use Domain\Source\Events\UpdateSourceEvent;
use App\Http\Requests\SourceRequest;
use App\Http\ViewModels\SourceViewModel;
use Domain\User\Models\User;

class UserSourcesController
{
    public function index(User $user)
    {
        $viewModel = new SourceViewModel($user);

        return $viewModel->view('userSources.index');
    }

    public function update(SourceRequest $request, User $user)
    {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            event(CreateSourceEvent::fromRequest($request));

            return redirect()->action([self::class, 'index']);
        }

        $updateSourceEvent = UpdateSourceEvent::fromRequest($primarySource, $request);

        if ($updateSourceEvent->hasChanges($primarySource)) {
            event($updateSourceEvent);
        }

        flash(__("Saved"));

        return redirect()->action([self::class, 'index']);
    }

    public function delete(User $user)
    {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            return redirect()->action([self::class, 'index']);
        }

        event(DeleteSourceEvent::create($primarySource));

        return redirect()->action([self::class, 'index']);
    }
}
