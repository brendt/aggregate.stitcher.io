<?php

namespace App\Posts;

use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\Console\Schedule;
use Tempest\Console\Scheduler\Every;
use function Tempest\Intl\Number\parse_int;
use function Tempest\Support\arr;

final class RankSourcesCommand
{
    use HasConsole;

    #[ConsoleCommand]
    #[Schedule(Every::DAY)]
    public function __invoke(): void
    {
        $sources = arr(Source::select()
            ->where('state', SourceState::PUBLISHED)
            ->all());

        $max = $sources->reduce(
            fn (int $max, Source $source) => max($max, $source->visits),
            0
        );

        $min = $sources->reduce(
            fn (int $min, Source $source) => min($min, $source->visits),
            0
        );

        $rebasedMax = $max - $min;

        $sources->each(function (Source $source) use ($min, $rebasedMax) {
            $rebasedValue = $source->visits - $min;

            if ($rebasedMax === 0) {
                $rank = 0;
            } else {
                $rank = parse_int(round($rebasedValue / $rebasedMax, 2) * 100);
            }

            $source->rank = $rank;
            $source->save();

            $this->success($source->uri . ' - ' . $rank);
        });
    }
}