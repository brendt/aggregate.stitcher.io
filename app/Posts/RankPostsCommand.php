<?php

namespace App\Posts;

use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\Console\Schedule;
use Tempest\Console\Scheduler\Every;
use function Tempest\Database\query;
use function Tempest\Intl\Number\parse_int;

final class RankPostsCommand
{
    use HasConsole;

    #[ConsoleCommand]
    #[Schedule(Every::HALF_DAY)]
    public function __invoke(): void
    {
        ['min' => $min, 'max' => $max] = query('posts')
            ->select('min(visits) as min', 'max(visits) as max')
            ->first();

        $rebasedMax = $max - $min;

        Post::select()
            ->with('source')
            ->where('state', PostState::PUBLISHED)
            ->chunk(function (array $posts) use ($min, $rebasedMax) {
                foreach ($posts as $post) {
                    $rebasedValue = $post->visits - $min;

                    if ($rebasedMax === 0) {
                        $rankByVisits = 0;
                    } else {
                        $rankByVisits = parse_int(round($rebasedValue / $rebasedMax, 2) * 100);
                    }

                    $rank = round($rankByVisits * match (true) {
                            $post->source->rank < 10 => 0.8,
                            $post->source->rank < 30 => 1.0,
                            $post->source->rank < 50 => 1.1,
                            $post->source->rank < 70 => 1.2,
                            $post->source->rank < 90 => 1.3,
                            default => 1.5,
                        });

                    $post->rank = $rank;
                    $post->save();

                    $this->success($post->uri . ' - ' . $rank);
                }
            });
    }
}