<?php

namespace App\Console;

use App\Console\Commands\SyncPostCountCommand;
use App\Console\Commands\SyncSourcesCommand;
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
            ->everyMinute()
            ->withoutOverlapping(60);

        $schedule
            ->command(SyncPostCountCommand::class)
            ->daily()
            ->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
