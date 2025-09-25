<?php

namespace App;

use App\Authentication\Role;
use App\Authentication\User;
use App\Factories\PostFactory;
use App\Factories\SourceFactory;
use App\Factories\SuggestionFactory;
use App\Posts\PostState;
use Tempest\Database\DatabaseSeeder;
use UnitEnum;
use function Tempest\env;

final class AppSeeder implements DatabaseSeeder
{
    public function run(UnitEnum|string|null $database): void
    {
        User::create(
            name: 'Brent',
            email: env('SEEDER_EMAIL', 'test@example.com'),
            role: Role::ADMIN,
        );

        $source = new SourceFactory()->make();

//        new PostFactory()->withSource($source)->times(40)->make();

        new PostFactory()->withState(PostState::PUBLISHED)->withSource($source)->times(40)->make();

//        new SuggestionFactory()->withUri('https://stitcher.io')->withFeedUri('https://stitcher.io/rss')->make();

//        Source::create(
//            name: 'stitcher.io',
//            uri: 'https://stitcher.io/rss',
//            state: SourceState::PUBLISHED,
//        );
    }
}
