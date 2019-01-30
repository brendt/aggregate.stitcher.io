<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestSourceRequest;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;

class GuestSourcesController
{
    public function index()
    {
        return view('guestSources.form');
    }

    public function store(
        GuestSourceRequest $sourceRequest,
        CreateSourceAction $createSourceAction
    ) {
        $url = $sourceRequest->getSourceUrl();

        if (! Source::whereUrl($url)->exists()) {
            $adminUser = User::whereAdmin()->first();

            $createSourceAction($adminUser, SourceData::fromRequest($sourceRequest));
        }

        return view('guestSources.success');
    }
}
