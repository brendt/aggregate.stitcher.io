<?php

namespace App\Support;

use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use App\Posts\SourceState;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use function Tempest\Support\arr;
use function Tempest\Support\str;

final readonly class FixSourceMigration
{
    use HasConsole;

    #[ConsoleCommand('migrate:sources')]
    public function __invoke(): void
    {
        $sources = arr(Source::select()->where('state', SourceState::PUBLISHED)->all());

        Post::select()
            ->where(
                '(posts.state = ? or posts.state = ?) AND source_id IS NULL',
                PostState::PENDING,
            PostState::PUBLISHED,
            )
            ->chunk(function (array $posts) use ($sources) {
                /** @var Post $post */
                foreach ($posts as $post) {
                    $source = $sources->first(function (Source $source) use ($post) {
                        return str(parse_url($source->uri, PHP_URL_HOST))->afterFirst('www.')->equals(
                            str(parse_url($post->uri, PHP_URL_HOST))->afterFirst('www.'),
                        );
                    });

                    if (! $source) {
                        $this->error($post->uri);
                        continue;
                    }

                    $post->update(
                        source: $source,
                    );

                    $this->success($post->uri);
                }
            });

        $this->writeln();
        $this->success("Done!");
    }
}