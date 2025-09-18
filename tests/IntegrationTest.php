<?php

namespace Tests;

use App\Authentication\CreateUsersTable;
use App\Posts\Migrations\AddRankToPosts;
use App\Posts\Migrations\AddRankToSources;
use App\Posts\Migrations\CreatePostsTable;
use App\Posts\Migrations\CreateSourcesTable;
use Tempest\Database\Migrations\CreateMigrationsTable;

abstract class IntegrationTest extends \Tempest\Framework\Testing\IntegrationTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupDatabase();
    }

    protected function migrateDatabase(): void
    {
        $this->migrate(
            CreateMigrationsTable::class,
            CreateUsersTable::class,
            CreateSourcesTable::class,
            CreatePostsTable::class,
            AddRankToSources::class,
            AddRankToPosts::class,
        );
    }
}