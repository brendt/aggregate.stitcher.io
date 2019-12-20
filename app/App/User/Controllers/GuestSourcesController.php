<?php

namespace App\User\Controllers;

use App\User\Controllers\UserSourcesController;
use App\User\Requests\GuestSourceRequest;
use App\User\ViewModels\GuestSourceViewModel;
use Domain\Language\LanguageRepository;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;

final class GuestSourcesController
{
    public function index(LanguageRepository $languageRepository)
    {
        $user = current_user();

        if ($user) {
            return redirect()->action([UserSourcesController::class, 'index']);
        }

        return (new GuestSourceViewModel($languageRepository))->view('guestSources.form');
    }

    public function store(
        GuestSourceRequest $sourceRequest,
        CreateSourceAction $createSourceAction
    ) {
        $url = $sourceRequest->getSourceUrl();

        if (! Source::whereUrl($url)->exists()) {
            $createSourceAction(null, SourceData::fromRequest($sourceRequest));
        }

        return view('guestSources.success');
    }
}
