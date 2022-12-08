<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\LinkVisit;
use App\Models\Post;
use App\Models\PostVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class AddLinkVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Link $link,
    ) {}

    public function handle()
    {
        $this->link->update([
            'visits' => $this->link->visits + 1,
        ]);

        LinkVisit::create([
            'link_id' => $this->link->id,
        ]);

        Link::query()
            ->orderByDesc('created_at')
            ->limit(100)
            ->get()
            ->each(fn (Link $link) => Cache::forget($this->link->getVisitsGraphCacheKey()));

        Cache::forget($this->link->getVisitsGraphCacheKey());
    }
}
