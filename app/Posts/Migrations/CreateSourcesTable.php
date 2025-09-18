<?php

namespace App\Posts\Migrations;

use App\Posts\SourceState;
use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;

final class CreateSourcesTable implements MigratesUp
{
    public string $name = '2025-09-17-000_create_sources_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('sources')
            ->primary()
            ->string('name')
            ->string('uri')
            ->integer('visits', unsigned: true, default: 0)
            ->enum('state', SourceState::class);
    }
}
