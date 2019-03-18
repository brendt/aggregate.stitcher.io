<?php

namespace App\Http\Controllers;

use App\Console\Jobs\SyncSourceJob;
use App\Http\Queries\AdminSourcesQuery;
use App\Http\Requests\AdminSourceRequest;
use App\Http\Requests\Request;
use App\Http\Requests\UserSourceRequest;
use App\Http\ViewModels\AdminSourceViewModel;
use App\Http\ViewModels\SourceViewModel;
use Domain\Source\Actions\ActivateSourceAction;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\Actions\DeleteSourceAction;
use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Actions\UpdateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;
use Domain\User\Models\User;

final class AdminSourcesController
{
    public function index(
        Request $request,
        AdminSourcesQuery $query
    ) {
        $sources = $query->paginate();

        return view('adminSources.index', [
            'sources' => $sources,
            'currentUrl' => $request->url(),
            'currentSearchQuery' => $request->get('filter')['search'] ?? null,
        ]);
    }

    public function edit(Source $source)
    {
        $viewModel = new AdminSourceViewModel($source);

        return $viewModel->view('adminSources.form');
    }

    public function update(
        AdminSourceRequest $sourceRequest,
        Source $source,
        UpdateSourceAction $updateSourceAction
    ) {
        $updateSourceAction($source, SourceData::fromRequest($sourceRequest, $source));

        return redirect()->back();
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

    public function confirmDelete(Source $source)
    {
        return view('adminSources.delete', [
            'source' => $source,
        ]);
    }

    public function delete(
        Source $source,
        DeleteSourceAction $deleteSourceAction
    ) {
        $deleteSourceAction($source);

        return redirect()->action([self::class, 'index']);
    }
}
