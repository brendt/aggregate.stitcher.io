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

        $source = $this->createSource($url);

        if ($request->user()) {
            $this->publishSource($source);

            return redirect()->action(AdminSourcesController::class);
        }

        Mail::to(User::find(1)->email)
            ->send(new SourceAddedMail($source));

        return redirect()->action(HomeController::class, [
            'message' => 'Thank you for your suggestion, we\'ll review it soon!',
        ]);
    }

    public function createSource(string $url): Source
    {
        $source = Source::create([
            'url' => $url,
        ]);

        if ($source->hasDuplicate()) {
            $source->update([
                'state' => SourceState::DUPLICATE,
            ]);
        }

        return $source;
    }

    public function publishSource(Source $source): void
    {
        $source->update([
            'state' => SourceState::PUBLISHING,
        ]);

        dispatch(new PublishSourceJob($source));
    }
}
