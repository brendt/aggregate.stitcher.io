<?php

namespace App\Http\Controllers;

use App\Http\Queries\AdminSourcesQuery;
use App\Http\Requests\AdminSourceRequest;
use Domain\Source\Events\ActivateSourceEvent;
use Domain\Source\Events\CreateSourceEvent;
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

    public function activate(Source $source)
    {
        event(new ActivateSourceEvent($source->uuid));

        return redirect()->back();
    }

    public function store(AdminSourceRequest $sourceRequest)
    {
        event(CreateSourceEvent::fromRequest($sourceRequest));

        return redirect()->back();
    }
}
