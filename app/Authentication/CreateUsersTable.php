<?php

namespace App\Authentication;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;

final class CreateUsersTable implements MigratesUp
{
    public string $name = '0000-00-00_create_users_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('users')
            ->primary()
            ->string('name')
            ->string('email')
            ->string('password', nullable: true)
            ->enum('role', Role::class);
    }
}
