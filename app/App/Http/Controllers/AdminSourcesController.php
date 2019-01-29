<?php

namespace App\Http\Controllers;

use App\Console\Jobs\SyncSourceJob;
use App\Http\Queries\AdminSourcesQuery;
use App\Http\Requests\AdminSourceRequest;
use Domain\Source\Actions\ActivateSourceAction;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;

class AdminSourcesController
{
    public function index(AdminSourcesQuery $query)
    {
        $sources = $query->paginate();

        return view('adminSources.index', [
            'sources' => $sources,
        ]);
    }

    public function activate(
        Source $source,
        ActivateSourceAction $activateSourceAction,
        SyncSourceAction $syncSourceAction
    ) {
        $activateSourceAction($source);

        dispatch_now(new SyncSourceJob($syncSourceAction, $source));

        return redirect()->back();
    }

    public function store(
        User $user,
        AdminSourceRequest $sourceRequest,
        CreateSourceAction $createSourceAction
    ) {
        $createSourceAction($user, SourceData::fromRequest($sourceRequest));

        return redirect()->back();
    }
}
