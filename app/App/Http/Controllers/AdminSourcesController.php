<?php

namespace App\Http\Controllers;

use App\Http\Queries\AdminSourcesQuery;
use App\Http\Requests\AdminSourceRequest;
use Domain\Source\Actions\ActivateSourceAction;
use Domain\Source\Actions\CreateSourceAction;
use Domain\Source\DTO\SourceData;
use Domain\Source\Models\Source;

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
        ActivateSourceAction $activateSourceAction
    ) {
        $activateSourceAction($source);

        return redirect()->back();
    }

    public function store(
        AdminSourceRequest $sourceRequest,
        CreateSourceAction $createSourceAction
    ) {
        $createSourceAction(SourceData::fromRequest($sourceRequest));

        return redirect()->back();
    }
}
