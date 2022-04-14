<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

final class StoreSourceSuggestionController
{
    public function __invoke(Request $request)
    {
        $url = $request->validate([
            'url' => ['required', 'url'],
        ])['url'];

        Source::create([
            'url' => $url,
        ]);

        return redirect()->action(HomeController::class, [
            'message' => 'Thank you for your suggestion, we\'ll review it soon!',
        ]);
    }
}
