<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sources;

use App\Http\Controllers\HomeController;
use App\Jobs\PublishSourceJob;
use App\Mail\SourceAddedMail;
use App\Models\Source;
use App\Models\SourceState;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

            return redirect()->action(AdminSourcesController::class);
        }

        Mail::to(User::find(1)->email)
            ->send(new SourceAddedMail($source));

        return redirect()->action(HomeController::class, [
            'message' => 'Thank you for your suggestion, we\'ll review it soon!',
        ]);
    }
}
