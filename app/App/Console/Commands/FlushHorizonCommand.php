<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Redis\Factory as RedisFactory;

class FlushHorizonCommand extends Command
{
    protected $signature = 'horizon:flush';

    protected $description = 'Flush Horizon';

    /** @var \Illuminate\Contracts\Redis\Factory */
    protected $redis;

    public function __construct(RedisFactory $redis)
    {
        parent::__construct();

        $this->redis = $redis;
    }

    public function handle(): void
    {
        $this->redis->connection('horizon')->flushdb();
    }
}
