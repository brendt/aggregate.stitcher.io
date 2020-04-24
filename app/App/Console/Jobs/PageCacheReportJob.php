<?php

namespace App\Console\Jobs;

use Carbon\Carbon;
use Domain\Analytics\Actions\UpdatePageCacheReportAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class PageCacheReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Carbon $day;

    public function __construct(Carbon $day)
    {
        $this->onQueue('sync');

        $this->day = $day;
    }

    public function handle(UpdatePageCacheReportAction $updatePageCacheReportAction): void
    {
        $updatePageCacheReportAction($this->day);
    }
}
