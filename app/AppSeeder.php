<?php

namespace App;

use App\Authentication\Role;
use App\Authentication\User;
use Tempest\Database\DatabaseSeeder;
use Tests\Factories\PostFactory;
use Tests\Factories\SourceFactory;
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

        new PostFactory()->withSource($source)->times(40)->make();

//        Source::create(
//            name: 'stitcher.io',
//            uri: 'https://stitcher.io/rss',
//            state: SourceState::PUBLISHED,
//        );
    }
}
