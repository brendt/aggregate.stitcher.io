<?php

namespace App\Console;

use App\Console\Commands\SyncPopularityIndexCommand;
use App\Console\Commands\SyncPostCountCommand;
use App\Console\Commands\SyncSourcesCommand;
use App\Console\Commands\TweetPostCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->command(SyncSourcesCommand::class)
            ->twiceDaily();

        $schedule
            ->command(SyncPostCountCommand::class)
            ->daily()
            ->withoutOverlapping();

        foreach (['01:02', '07:08', '12:49', '19:10'] as $hour) {
            $schedule
                ->command(TweetPostCommand::class)
                ->dailyAt($hour);
        }

        $schedule
            ->command(SyncPopularityIndexCommand::class)
            ->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
