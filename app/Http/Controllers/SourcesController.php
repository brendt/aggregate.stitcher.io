<?php

namespace App\Http\Controllers;

use App\Domain\Source\Events\CreateSourceEvent;
use App\Domain\Source\Events\DeleteSourceEvent;
use App\Domain\Source\Events\UpdateSourceEvent;
use App\Http\Requests\SourceRequest;
use App\Http\ViewModels\SourceViewModel;
use Domain\User\Models\User;

class SourcesController
{
    public function edit(User $user)
    {
        $viewModel = new SourceViewModel($user);

        return $viewModel->view('sources.form');
    }

    public function update(SourceRequest $request, User $user)
    {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            event(CreateSourceEvent::fromRequest($request));

            return redirect()->action([self::class, 'edit']);
        }

        $updateSourceEvent = UpdateSourceEvent::fromRequest($primarySource, $request);

        if ($updateSourceEvent->hasChanges($primarySource)) {
            event($updateSourceEvent);
        }

        return redirect()->action([self::class, 'edit']);
    }

    public function delete(User $user)
    {
        $primarySource = $user->getPrimarySource();

        if (! $primarySource) {
            return redirect()->action([self::class, 'edit']);
        }

        event(DeleteSourceEvent::create($primarySource));

        return redirect()->action([self::class, 'edit']);
    }
}
