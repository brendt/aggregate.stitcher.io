<?php

namespace App;

use App\Authentication\Role;
use App\Authentication\User;
use App\Posts\Source;
use App\Posts\SourceState;
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

        Source::create(
            name: 'stitcher.io',
            uri: 'https://stitcher.io/rss',
            state: SourceState::PUBLISHED,
        );
    }
}
