<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\PublishSourceJob;
use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Http\Request;

final class StoreSourceSuggestionController
{
    public function __invoke(Request $request)
    {
        $url = $request->validate([
            'url' => ['required', 'url'],
        ])['url'];

        $source = Source::create([
            'url' => $url,
        ]);

        if ($request->user()) {
            $source->update([
                'state' => SourceState::PUBLISHING,
            ]);

            dispatch(new PublishSourceJob($source));

            return redirect()->action(SourcesAdminController::class);
        }

        return redirect()->action(HomeController::class, [
            'message' => 'Thank you for your suggestion, we\'ll review it soon!',
        ]);
    }
}
