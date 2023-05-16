<?php

namespace App\Http\Livewire;

use App\Models\PostShare;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class ShareTimeline extends Component
{
    protected $listeners = ['postShareAdded'];

    public function render()
    {
        $postShares = PostShare::query()
            ->whereNull('shared_at')
            ->orderBy('share_at')
            ->with('post')
            ->get()
            ->groupBy(fn (PostShare $postShare) => $postShare->share_at->format('Y-m-d'));

        $currentDay = Carbon::make($postShares->keys()->first());
        $maxDay = Carbon::make($postShares->keys()->last());

        $timeline = [];

        while ($currentDay && $currentDay <= $maxDay) {
            $timeline[$currentDay->format('Y-m')] ??= [];
            $timeline[$currentDay->format('Y-m')][$currentDay->format('Y-m-d')] = $postShares[$currentDay->format('Y-m-d')] ?? [];
                $currentDay->addDay();
        }

        return view('livewire.share-timeline', [
            'timeline' => $timeline,
        ]);
    }

    public function postShareAdded(): void
    {
        // Just re-rendering
    }
}
