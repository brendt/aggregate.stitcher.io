<?php

namespace App\Console\Jobs;

use Domain\Source\Actions\SyncSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Source\Actions\SyncSourceAction */
    protected $updateSource;

    /** @var \Domain\Source\Models\Source */
    protected $source;

    public function __construct(SyncSourceAction $updateSource, Source $source)
    {
        $this->updateSource = $updateSource;
        $this->source = $source;
    }

    public function handle()
    {
        $this->updateSource->__invoke($this->source);
    }
}
