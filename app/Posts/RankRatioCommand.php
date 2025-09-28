<?php

namespace App\Posts;

use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\Console\Schedule;
use Tempest\Console\Scheduler\Every;
use function Tempest\Intl\Number\parse_int;
use function Tempest\Support\arr;

final class RankRatioCommand
{
    use HasConsole;

    #[ConsoleCommand]
    #[Schedule(Every::DAY)]
    public function __invoke(): void
    {
        $sources = arr(Source::select()->all());

        foreach ($sources as $source) {
            $amountPublished = Post::count()
                ->where('source_id', $source->id)
                ->where('state', PostState::PUBLISHED)
                ->execute();

            $amountTotal = Post::count()
                ->where('source_id', $source->id)
                ->execute();
            if ($amountTotal === 0) {
                continue;
            }

            $ratio = (int) floor((($amountPublished / $amountTotal) * 100));

            $source->publicationRatio = $ratio;
            $source->save();

            $this->success($source->uri . ' - ' . $ratio);
        }
    }
}