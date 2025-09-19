<?php

namespace Tests;

use App\Authentication\CreateUsersTable;
use App\Authentication\Role;
use App\Authentication\User;
use App\Posts\Migrations\AddPublicationDateToPost;
use App\Posts\Migrations\AddRankToPosts;
use App\Posts\Migrations\AddRankToSources;
use App\Posts\Migrations\CreatePostsTable;
use App\Posts\Migrations\CreateSourcesTable;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Database\Migrations\CreateMigrationsTable;
use Tests\Factories\UserFactory;

abstract class IntegrationTestCase extends \Tempest\Framework\Testing\IntegrationTest
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
            AddPublicationDateToPost::class,
        );
    }

    protected function login(?User $user = null, ?Role $role = null): User
    {
        if ($user === null) {
            $factory = UserFactory::new();

            if ($role) {
                $factory = $factory->withRole($role);
            }

            $user = $factory->make();
        }

        $this->container->get(Authenticator::class)->authenticate($user);

        return $user;
    }
}