<?php

namespace App\Links;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\CreateTableStatement;

final class CreateLinksTable implements MigratesUp
{
    public string $name = '2025-09-17_003_create_links_table';

    public function up(): QueryStatement
    {
        return new CreateTableStatement('links')
            ->primary()
            ->string('uuid')
            ->string('uri')
            ->string('title', nullable: true)
            ->integer('visits', unsigned: true, default: 0);
    }
}