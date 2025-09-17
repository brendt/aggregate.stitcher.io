<?php

namespace App;

use App\Links\Link;
use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use App\Posts\SourceState;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\HasConsole;
use Tempest\Container\Tag;
use Tempest\Database\Database;
use Tempest\Database\Query;
use Tempest\DateTime\DateTime;
use function Tempest\Database\query;

final class MigrateDatabaseCommand
{
    use HasConsole;

    public function __construct(
        #[Tag('old')] private readonly Database $old,
    ) {}

    #[ConsoleCommand]
    public function __invoke(): void
    {
        $this->syncLinks();

        $this->syncSources();

        $this->syncPosts();
    }

    public function syncSources(): void
    {
        $sourceItems = $this->old->fetch(new Query('SELECT * FROM sources'));

        foreach ($sourceItems as $item) {
            $id = $item['id'];

            if ($source = Source::select()->where('id', $id)->first()) {
                $this->info("{$source->name} already exists");

                continue;
            }

            $source = Source::create(
                id: $id,
                uri: $item['url'],
                name: $item['name'],
                state: SourceState::tryFrom($item['state']) ?? SourceState::PENDING,
            );

            $this->success("{$source->uri} created");
        }
    }

    public function syncPosts(): void
    {
        $postItems = $this->old->fetch(new Query('SELECT * FROM posts'));

        foreach ($postItems as $item) {
            $id = $item['id'];

            if ($post = Post::select()->where('id', $id)->first()) {
                $this->info("{$post->title} already exists");

                continue;
            }

            if ($item['source_id'] === null) {
                continue;
            }

            if ($item['created_at'] === null) {
                continue;
            }

            query(Post::class)->insert(
                id: $id,
                source_id: $item['source_id'],
                uri: $item['url'],
                title: $item['title'],
                visits: $item['visits'],
                createdAt: DateTime::parse($item['created_at']),
                state: PostState::tryFrom($item['state']) ?? PostState::PENDING,
            )->execute();

            $this->success("{$item['title']} created");
        }
    }

    private function syncLinks(): void
    {
        $linkItems = $this->old->fetch(new Query('SELECT * FROM links'));

        foreach ($linkItems as $item) {
            $id = $item['id'];

            if ($link = Link::select()->where('id', $id)->first()) {
                $this->info("{$link->uri} already exists");

                continue;
            }

            query(Link::class)->insert(
                id: $id,
                uuid: $item['uuid'],
                uri: $item['url'],
                title: $item['title'],
                visits: $item['visits'],
            )->execute();

            $this->success("Link `{$item['title']}` created");
        }
    }
}