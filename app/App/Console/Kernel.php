<?php

namespace App\Console;

use App\Console\Commands\SyncSourcesCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
    ];

    protected function schedule(Schedule $schedule)
    {
//        $schedule
//            ->command(SyncSourcesCommand::class)
//            ->everyMinute()
//            ->withoutOverlapping(60);
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
