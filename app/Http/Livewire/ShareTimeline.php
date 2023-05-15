<?php

namespace App\Http\Livewire;

use App\Models\PostShare;
use Carbon\Carbon;
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

        $postSharesPerDay = collect();

        while ($currentDay && $currentDay <= $maxDay) {
            $postSharesPerDay[$currentDay->format('Y-m-d')] = $postShares[$currentDay->format('Y-m-d')] ?? [];
            $currentDay->addDay();
        }

        return view('livewire.share-timeline', [
            'postSharesPerDay' => $postSharesPerDay,
        ]);
    }

    public function postShareAdded(): void
    {
        // Just re-rendering
    }
}
