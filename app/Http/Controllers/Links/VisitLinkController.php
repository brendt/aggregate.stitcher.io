<?php

namespace App\Http\Controllers\Links;

use App\Jobs\AddLinkVisitJob;
use App\Models\Link;

final class VisitLinkController
{
    public function __invoke(Link $link)
    {
        dispatch(new AddLinkVisitJob($link));

        return redirect()->to($link->url);
    }
}
