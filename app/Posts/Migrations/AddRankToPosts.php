<?php

namespace App\Posts\Migrations;

use Tempest\Database\MigratesUp;
use Tempest\Database\QueryStatement;
use Tempest\Database\QueryStatements\AlterTableStatement;
use Tempest\Database\QueryStatements\IntegerStatement;

final class AddRankToPosts implements MigratesUp
{
    public string $name = '2025-09-18-002_add_rank_to_sources_table';

    public function up(): QueryStatement
    {
        return new AlterTableStatement('posts')
            ->add(new IntegerStatement('rank', unsigned: true, default: 0));
    }
}