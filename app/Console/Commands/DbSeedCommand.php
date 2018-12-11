<?php

namespace App\Console\Commands;

use DatabaseSeeder;
use Illuminate\Console\Command;

class DbSeedCommand extends Command
{
    protected $signature = 'db:seed {--clean} {--posts}';

    protected $description = 'Seed database';

    public function handle(DatabaseSeeder $databaseSeeder)
    {
        if ($this->option('clean')) {
            $this->call('migrate:fresh');
        }

        $databaseSeeder
            ->setCommand($this)
            ->withPosts($this->option('posts'))
            ->run();
    }
}
