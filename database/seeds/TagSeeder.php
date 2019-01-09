<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /** @var \App\Console\Jobs\SyncTagsAndTopicsJob */
    private $syncTagsAndTopicsJob;

    public function __construct()
    {
        $this->syncTagsAndTopicsJob = app(\App\Console\Jobs\SyncTagsAndTopicsJob::class);
    }

    public function run()
    {
        dispatch_now($this->syncTagsAndTopicsJob);
    }
}
