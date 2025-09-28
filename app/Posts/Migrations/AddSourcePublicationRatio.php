<?php

namespace App\Posts\Migrations;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\AlterTableStatement;
use Tempest\Database\QueryStatements\IntegerStatement;

final class AddSourcePublicationRatio implements MigratesUp
{
    public string $name = '2025-09-28_add_sources_publication_ratio';

    public function up(): QueryStatement
    {
        return new AlterTableStatement('sources')
            ->add(new IntegerStatement('publicationRatio', unsigned: true, default: 0));
    }
}