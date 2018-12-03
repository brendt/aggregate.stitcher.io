<?php

namespace App\Console\Jobs;

use Domain\Source\Actions\UpdateSourceAction;
use Domain\Source\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Domain\Source\Actions\UpdateSourceAction */
    protected $updateSource;

    /** @var \Domain\Source\Models\Source */
    protected $source;

    public function __construct(UpdateSourceAction $updateSource, Source $source)
    {
        $this->updateSource = $updateSource;
        $this->source = $source;
    }

    public function handle()
    {
        $this->updateSource->execute($this->source);
    }
}
