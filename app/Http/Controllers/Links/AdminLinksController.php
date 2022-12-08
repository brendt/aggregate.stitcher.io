<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;
use Illuminate\Http\Request;

final class AdminLinksController
{
    public function __invoke(Request $request)
    {
        $links = Link::query()->orderByDesc('created_at')->paginate(100);

        return view('adminLinks', [
            'links' => $links,
            'message' => $request->get('message'),
        ]);
    }
}
