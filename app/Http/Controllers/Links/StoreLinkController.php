<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;
use Illuminate\Http\Request;

final class StoreLinkController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'url' => ['url']
        ]);

        Link::create([
            'url' => $validated['url'],
        ]);

        return redirect()->action(AdminLinksController::class);
    }
}
