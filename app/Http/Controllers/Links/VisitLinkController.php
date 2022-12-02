<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;

final class VisitLinkController
{
    public function __invoke(Link $link)
    {
        $link->update([
            'visits' => $link->visits + 1,
        ]);

        return redirect()->to($link->url);
    }
}
