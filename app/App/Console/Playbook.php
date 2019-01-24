<?php

namespace App\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Playbook
{
    public static $timesRun = 0;

    public static function times(int $times): PlaybookDefinition
    {
        return PlaybookDefinition::times(static::class, $times);
    }

    public static function once(): PlaybookDefinition
    {
        return PlaybookDefinition::once(static::class);
    }

    public function before(): array
    {
        return [];
    }

    abstract public function run(InputInterface $input, OutputInterface $output);

    public function hasRun()
    {
        self::$timesRun += 1;
    }

    public function timesRun(): int
    {
        return self::$timesRun;
    }

    public function after(): array
    {
        return [];
    }
}
